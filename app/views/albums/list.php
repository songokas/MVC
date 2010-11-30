
<? if ($albums): ?>
    <div class="header">
        <div>ID</div>
        <div>Title</div>
        <div>Author</div>
        <div>Edit</div>
        <div>Delete</div>
    </div>
<? foreach ($albums as $album) : ?>

        <div class="list">
            <div><?= $album->id ?></div>
            <div><?= $album->title ?></div>
            <div><?= $album->author ?></div>
            <div><a href="<?= url('albums/edit/' . $album->id) ?>">edit</a></div>
            <div><a href="<?= url('albums/delete/' . $album->id) ?>">delete</a></div>

        </div>
<? endforeach; ?>

<? endif; ?>
            <div><a href="<?= url('albums/edit') ?>">Add</a></div>
