### webpipe.bash.php

Webpipes are handy when you want to do powerfull bashscripting without the limitations of your current architecture/packages.
This repository contains one example webpipe 'json_print_r' which functions as an startingpoint for other webpipes.

### Demonstration

A demonstration of a tool which utilitizes webpipes can seen [here](https://bashlive.com)

### Howto use

Adviced is to use [bashlive](http://bashlive.com) or [webpipe.bash](https://github.com/coderofsalvation/webpipe.bash) so the webpipes appear as normal unix commands (as seen 
in the demonstration above).
For testing purposes also curl can be used directly (see the following section), to process:

    curl -L -X POST -d 'putyourpostdatahere' -H Content-Type: text/plain http://myurl.com/json_print_r
    curl -L -X POST -d 'putyourpostdatahere' -H Content-Type: text/html  http://myurl.com/json_print_r
    curl -L -X POST -d 'putyourpostdatahere' -H Content-Type: text/csv   http://myurl.com/json_print_r

Or to get the options:

    curl -L -X OPTIONS -H 'Content-Type: text/plain' http://myurl.com/json_print_r

### normal vs webpipe

Interestingly enough it looks like webpipes run faster than normal forks when run locally.
This is when we spawn php ourselves (it does a simple print_r( json_decode( $GLOBALS['argv'][1] ) );

    $ time ./test.php '{"foo":["bar","flop","flap"]}'

    real    0m0.018s
    user    0m0.009s
    sys     0m0.006s

And here's when we do it using a webpipe:

    $ time curl -L -X POST -d '{"foo":["bar","flop","flap"]}' -H 'Content-Type: text/plain' http://localhost/webpipes/json_print_r.php

    real    0m0.008s
    user    0m0.003s
    sys     0m0.002s

Im not exactly sure why this is faster, but I guess apache is already waiting with a default X running processes.
If for whatever reason this test is not valid let me know.

### Compatibility with WebPipe Specification 0.2

The webpipes above are more or less compatible.
Noted should be that the webpipes are used mainly as simple unix webpipes (text in, text out), hence the 
php webpipe is defaulting to single-input, single-output (in contrast to the multi-jsoninput multi-jsonoutput requirement
of the webpipe specification).
However, the multi-jsoninput multi-jsonoutput requirement *does* apply when you call it with content-type 'application/json':
    
    $ curl -X POST -d '{"inputs":[{"css":".foo { font-weight:bold; }"}]}' -H 'Content-Type: application/json' http://localhost/json_print_r.php

However, this multi-in multi-out-assumption of the specs doesnt really fit my needs, therefore for practical reasons contenttypes 'text/plain' and 'text/html' default 
to single-textinput single-textoutput..the default behaviour of any webserver.

