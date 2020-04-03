
<div class="jokelist">
    <ul class="categories">
        <?php foreach ($categories as $category): ?>
            <li><a href="/joke/list?category=<?=$category->id?>"><?=$category->name?></a></li>
        <?php endforeach; ?>
        <li><a href="/joke/list">All</a></li>
    </ul>
</div>

<div class="jokes">
    <p><?=$totJ ?> jokes have been submitted to the Internet Joke Database.</p>

    <?php foreach($jokes as $joke): ?>
        <blockquote>
            <?=(new \Ninja\Markdown($joke->joketext))->toHtml()?>
            (by <a href="mailto:<?=htmlspecialchars($joke->getAuthor()->email, ENT_QUOTES, 'UTF-8'); ?>">
            <?=htmlspecialchars($joke->getAuthor()->name, ENT_QUOTES, 'UTF-8'); ?></a> on 
            <?php
                $date = new DateTime($joke->jokedate);

                echo $date->format('jS F Y');
            ?>)
            <?php if ($user): ?>
                <?php if ($user->id == $joke->authorId || $user->hasPermission(\Ijdb\Entity\Author::JOKES_EDIT)): ?>
                    <a href="/joke/edit?id=<?=$joke->id?>">Edit</a>
                <?php endif; ?>
                <?php if ($user->id == $joke->authorId || $user->hasPermission(\Ijdb\Entity\Author::JOKES_DELETE)): ?>
                    <form action="/joke/delete" method="post" accept-charset="utf-8">
                    <input type="hidden" value="<?=$joke->id?>" name="id"/>
                    <input type="submit" value="Delete"/>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </blockquote>
    <?php endforeach; ?>

    Select page:
    <?php
        $numPages = ceil($totJ/2);
        for ($i = 1; $i <= $numPages; $i++):
            if ($i == $currentPage):?>
<a class="currentpage" href="/joke/list?page=<?=$i?><?=!empty($categoryId) ? '&category=' . $categoryId : '' ?>"><?=$i?></a>
<?php else: ?>
<a href="/joke/list?page=<?=$i?><?=!empty($categoryId) ? '&category=' . $categoryId : '' ?>"><?=$i?></a>
<?php endif; ?>
<?php endfor; ?>
</div>
