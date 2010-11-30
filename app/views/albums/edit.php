
<div id="albums-block">
    <form action="<?=url('albums/save')?>" method="post">
        <? if ( !empty($album->id)) : ?>
            <input type="hidden" name="id" value="<?=$album->id?>" />
        <? endif; ?>
        <div><label>Title<input type="text" size="50" name="title" value="<?=$album->title?>" /></label></div>
        <div><label>Author<input type="text" size="50" name="author" value="<?=$album->author?>" /></label></div>
        <div><input type="submit" value="Save"/> <a href="<?=url('albums/show')?>">Back</a></div>

    </form>
</div>