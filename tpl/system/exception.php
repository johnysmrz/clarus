<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title><?php echo $e->getMessage() ?></title>
    </head>
    <body>
        <style type="text/css">
            #mainBox {
                width: 90%;
                top: 0;
                margin: 0px auto 0px auto;
            }

            #headBox {
                background-color: FireBrick;
                padding: 10px;
                color: gold;
            }

            #headBox dt {
                display: inline;
            }

            #headBox dt {
                display: inline;
            }

            #traceBox {
                background-color: LemonChiffon;
                padding: 10px;
            }

            #footBox {
                background-color: FireBrick;
                height: 30px;
                width: 100%;
            }

            #traceBox > table td {
                padding: 1px 3px 1px 3px;
            }

            #traceBox > table th {
                color: FireBrick;
            }
        </style>
        <div id="mainBox">
            <div id="headBox">
                <h1><?php echo get_class($e) ?>(<?php echo $e->getCode() ?>)</h1>
                <table>
                    <tr>
                        <td>Messsage</td>
                        <td><?php echo $e->getMessage() ?></td>
                    </tr>
                    <tr>
                        <td>Code</td>
                        <td><?php echo $e->getCode() ?></td>
                    </tr>
                    <tr>
                        <td>File</td>
                        <td><?php echo $e->getFile() ?></td>
                    </tr>
                    <tr>
                        <td>Line</td>
                        <td><?php echo $e->getLine() ?></td>
                    </tr>
                </table>
            </div>
            <div id="traceBox">
                <table>
                    <tr>
                        <th>no.</th>
                        <th>File</th>
                        <th>Line</th>
                        <th>Call</th>
                    </tr>
                    <?php foreach ($e->getTrace() as $key => $trace): ?>
                        <tr>
                            <td>#<?php echo $key ?></td>
                            <td><?php echo @$trace['file'] ?></td>
                            <td><?php echo @$trace['line'] ?></td>
                            <td><?php echo @$trace['class'] . $trace['type'] . $trace['function']; ?>(<?php echo implode(',', $trace['args']) ?>)</td>
                        </tr>
                    <? endforeach; ?>
                </table>
            </div>
            <div id="footBox">

            </div>
        </div>
    </body>
</html>
