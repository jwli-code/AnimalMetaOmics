proj=yourproj
item=youritem
mkdir -p ~/MPA/out_a_u/$proj/$item

#MPA
time java -cp ~/miniconda3/pkgs/mpa-portable-1.4.1-2/share/mpa-portable-1.4.1-2/mpa-portable-1.4.1.jar de.mpa.cli.CmdLineInterface -spectrum_files ~/MPA_run_a_u/$item.mgf -database ~/MPA_DB/uniprot_sprot_archaea.dat.fasta -prec_tol 4.5ppm -missed_cleav 1 -frag_tol 0.5Da -xtandem 1 -comet 1 -msgf 1 -iterative_search 0 -fdr_threshold 0.01 -generate_metaproteins 1 -peptide_rule 0 -cluster_rule -1 -taxonomy_rule -1 -threads 128 -output_folder ~/MPA/out_a_u/$proj/$item