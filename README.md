# Assets aggregator

Una classe in PHP con il solo scopo di velocizzare un sito web. 
Attenzione. L'ho scritta in poco meno di 20 minuti, quindi non e' ancora testata al meglio, ma sembra fare quello per cui e' costruita. 

## Scopo

Scopo della classe e' quello di aggregare i vari assets, per il momento solo js e css, in unico file. In questo modo si risolve il problema di avere molte, per non dire troppe, richieste http che rallentano il sito e danno un punteggio basso su google pagespeed. La classe non e' ancora testata benissimo, ho avuto solo 20 minuti di tempo per scriverla, ma apparentemente fa il suo dovere. L'ho usata su un sito di test e sono passato da un punteggio di 49 (fonte google pagespeed) a circa 80. Chiaramente una volta aggregati gli assets bisogna rimuovere tutte le linee di inclusione nel file. 

The purpose of the class is to aggregate the various assets, for the moment only js and css, in one file. This solves the problem of having too many http requests that slow down the site and give a low score on google pagespeed. The class is not tested very well yet as long I had only 20 minutes to dedicate to it but looks like is doing what is build for. I used it on a test site and i went from a score of 49 (source google pagespeed) to about 80-85. Clearly, once the assets have been aggregated, you have to remove all the lines of assets inclusion in the code.

## Uso

Sostituisci nelle linee seguenti:
- indirizzo sito web;
- nome cartella in cui verranno salvati i file degli assets aggregati (devi avere permessi di scrittura e lettura);
- tipo di asset (js e css al momento).

File assetsaggregator.php

`
$assets = new AssetsAggregator("https://ziobelo.com", "assets", "js");
$assets->process();
`


