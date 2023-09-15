
mkdir -p seq temp result

# FastQC
    
    fastqc seq/*.gz -t 2

# Fastp
    i=C1
    fastp -i seq/${i}_1.fq.gz -o temp/qc/${i}_1.fastq -I seq/${i}_2.fq.gz -O temp/qc/${i}_2.fastq

 
# KneadData
    kneaddata -i seq/${i}_1.fq.gz -i seq/${i}_2.fq.gz \
      -o temp/qc -v -t 8 --remove-intermediate-output \
      --trimmomatic ${soft}/envs/meta/share/trimmomatic/ \
      --trimmomatic-options "ILLUMINACLIP:${soft}/envs/meta/share/trimmomatic/adapters/TruSeq2-PE.fa:2:40:15 SLIDINGWINDOW:4:20 MINLEN:50" \
      --reorder --bowtie2-options "--very-sensitive --dovetail" \
      -db ${db}/kneaddata/animal_genome/hg37dec_v0.1


 
  fastqc temp/qc/*_1_kneaddata_paired_*.fastq -t 2
  	multiqc -d temp/qc/ -o result/qc/

# Assemble-based
    megahit -t 6 \
    	-1 `tail -n+2 result/metadata.txt|cut -f1|sed 's/^/temp\/qc\//;s/$/_1.fastq/'|tr '\n' ','|sed 's/,$//'` \
        -2 `tail -n+2 result/metadata.txt|cut -f1|sed 's/^/temp\/qc\//;s/$/_2.fastq/'|tr '\n' ','|sed 's/,$//'` \
        -o temp/megahit 

# QUAST
    quast.py result/megahit/final.contigs.fa -o result/megahit/quast -t 2

   

# MetaWRAP


    mkdir -p seq
    ln -s `pwd`/temp/seq/*.fastq seq/
    

    rm -rf temp/megahit_*
    time parallel -j ${j} \
    "metawrap assembly \
        -1 seq/{}_1.fastq \
        -2 seq/{}_2.fastq \
        -o temp/megahit_{} \
        -m 100 -t ${p} --megahit" \
     ::: `ls seq/|cut -f1 -d '_'|uniq`  

# Bin
 
    parallel -j ${j} \
    "metawrap binning \
        -o temp/binning_{} -t ${p} \
        -a temp/megahit_{}/final_assembly.fasta \
        --metabat2 --maxbin2 --concoct \
        seq/{}_*.fastq" \
    ::: `ls seq/|cut -f1 -d '_'|uniq`
     


     parallel -j ${j} \
    "metawrap bin_refinement \
      -o temp/bin_refinement_{} -t ${p} \
      -A temp/binning_{}/metabat2_bins/ \
      -B temp/binning_{}/maxbin2_bins/ \
      -C temp/binning_{}/concoct_bins/ \
      -c ${c} -x ${x}" \
    ::: `ls seq/|cut -f1 -d '_'|uniq`

# dRep


    mkdir -p temp/drep_in


    ln -s `pwd`/temp/bin_refinement/metawrap_50_10_bins/bin.* temp/drep_in/
    rename 'bin' 'mix_all' temp/drep_in/bin.*
    

    for i in `ls seq/|cut -f1 -d '_'|uniq`;do
       ln -s `pwd`/temp/bin_refinement_${i}/metawrap_50_10_bins/bin.* temp/drep_in/
       rename "bin." "s_${i}" temp/drep_in/bin.*
    done


    ls temp/drep_in/|cut -f 1 -d '_'|uniq -c

    ls temp/drep_in/|cut -f 2 -d '_'|cut -f 1 -d '.' |uniq -c


    mkdir -p temp/drep95

    dRep dereplicate temp/drep95/ \
      -g temp/drep_in/*.fa \
      -sa 0.95 -nc 0.30 -comp 50 -con 10 -p 3
    




# metaProdigal
    mkdir -p temp/prodigal
    prodigal -i result/megahit/final.contigs.fa \
        -d temp/prodigal/gene.fa \
        -o temp/prodigal/gene.gff \
        -p meta -f gff > temp/prodigal/gene.log 2>&1 

# cd-hit
    cd-hit-est -i temp/prodigal/gene.fa \
        -o result/NR/nucleotide.fa \
        -aS 0.9 -c 0.95 -G 0 -g 0 -T 0 -M 0

# seqkit
    seqkit translate --trim result/NR/nucleotide.fa \
        > result/NR/protein.fa 


# salmon
    mkdir -p temp/salmon

    salmon index \
      -t result/NR/nucleotide.fa \
      -p 9 \
      -i temp/salmon/index 


# ggNOG(COG/KEGG/CAZy)

    mkdir -p temp/eggnog
    emapper.py --no_annot --no_file_comments --override \
      --data_dir ${db}/eggnog \
      -i result/NR/protein.fa \
      --cpu 9 -m diamond \
      -o temp/eggnog/protein

# emapper

    emapper.py \
      --annotate_hits_table temp/eggnog/protein.emapper.seed_orthologs \
      --data_dir ${db}/eggnog \
      --cpu 9 --no_file_comments --override \
      -o temp/eggnog/output


# summarizeAbundance 
    mkdir -p result/eggnog

    summarizeAbundance.py \
      -i result/salmon/gene.TPM \
      -m temp/eggnog/output \
      -c '7,12,19' -s '*+,+,' -n raw \
      -o result/eggnog/eggnog

# dbCAN2
    mkdir -p temp/dbcan2

    diamond blastp \
      --db /db/dbcan2/CAZyDB.09242021 \
      --query result/NR/protein.fa \
      --threads 9 -e 1e-3 --outfmt 6 --max-target-seqs 1 --quiet \
      --out temp/dbcan2/gene_diamond.f6

# dbcan2list 
    mkdir -p result/dbcan2
    # 提取基因与dbcan分类对应表
    format_dbcan2list.pl \
      -i temp/dbcan2/gene_diamond.f6 \
      -o temp/dbcan2/gene.list 

#  CARD

    cut -f 1 -d ' ' result/NR/protein.fa > temp/protein.fa

    rgi main -i temp/protein.fa -t protein \
      -n 9 -a DIAMOND --include_loose --clean \
      -o result/card/protein
      




