### webpipe.bash.php

Webpipes are handy when you want to do powerfull bashscripting without the limitations of your current architecture/packages.
This repository runs live at google app engine.
It contains one example webpipe 'json_print_r' which functions as an startingpoint for other webpipes.

### Howto use

(to do)

### normal vs webpipe

Interestingly enough it looks like webpipes run faster than normal forks when run locally.
This is when we spawn php ourselves (it does a simple print_r( json_decode( $GLOBALS['argv'][1] ) );

    $ time ./test.php {"inputs":[{"css":".foo { font-weight:bold; }"}]}

    real    0m0.018s
    user    0m0.009s
    sys     0m0.006s

And here's when we do it using a webpipe:

    $ time curl -X POST -d {"inputs":[{"css":".foo { font-weight:bold; }"}]} -H Content-Type: application/json http://localhost/webpipes/json_print_r.php

    real    0m0.008s
    user    0m0.003s
    sys     0m0.002s

Im not exactly sure why this is faster, but I guess apache is already waiting with a default X running processes.
If for whatever reason this test is not valid let me know.

### Compatibility with WebPipe Specification 0.2

The webpipes above are more or less compatible.
Since the webpipes are used mainly as simple unix webpipes (text in, text out), they 
could easily be wrapped by the 0.2 specs.
However, this multi-in multi-out-assumption of the specs doesnt really fit my needs, and
 I can think of many reasons why its better to assume single-input single-output..

Therefore, for practical reasons I left it out.

