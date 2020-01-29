<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/jokes.css">
        <title><?=$title?></title>
    </head>
    <body>
        
        <header>
            <h1>IJDB</h1>
        </header>
        
        <nav>
            <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/joke/list">Jokes</a></li>
	    <li><a href="/joke/edit">Add a new joke</a></li>
            </ul>
        </nav>
        
        <main>
            <?=$output?>
        </main>

        <?php include 'footer.html.php'; ?>
    </body>
</html>
