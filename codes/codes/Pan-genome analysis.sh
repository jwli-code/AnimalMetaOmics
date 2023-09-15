#fastANI
fastANI -ql genome1.list -rl genome2.list -o output.txt

#Prokka
prokka genomic.fna --outdir annotation --prefix test --kingdom Bacteria

#Roary
roary -e --mafft -p 8 *.gff