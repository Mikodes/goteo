<?php
// Vista para pintar una entrada de blog
// puede ser resumen en la lista o completa
	use Goteo\Library\Text,
		Goteo\Model\Blog\Post;

    $post = Post::get($this['post']);
    $level = (int) $this['level'] ?: 3;
    
	if ($this['show'] == 'list') {
		$post->text = Text::recorta($post->text, 500);
	}

    $url = empty($this['url']) ? '/blog/' : $this['url'];
?>
	<h<?php echo $level + 1?>><a href="<?php echo $url.$post->id; ?>"><?php echo $post->title; ?></a></h<?php echo $level + 1?>>
	<span class="date"><?php echo $post->fecha; ?></span>
	<?php if (!empty($post->tags)) : $sep = '';?>
		<span class="categories">
            <?php foreach ($post->tags as $key => $value) :
                echo $sep.'<a href="/blog/?tag='.$key.'">'.$value.'</a>';
            $sep = ', '; endforeach; ?>
        </span>
	<?php endif; ?>
	<?php if (!empty($post->gallery)) : ?>
    <div class="gallery">
        <?php $i = 1; foreach ($post->gallery as $image) : ?>
        <div class="gallery-image">
            <img src="/image/<?php echo $image->id; ?>/500/285" alt="<?php echo $post->title; ?>" />
        </div>
        <?php $i++; endforeach; ?>

        <!-- si tiene varias imágenes, carrusel
        <ul class="navi">
            <li> &lt; carrusel &gt; </li>
        </ul>
        carrusel de imagenes -->
    </div>
	<?php endif; ?>
	<?php if (!empty($post->media->url)) : ?>
		<div class="embed">
			<?php echo $post->media->getEmbedCode(); ?>
		</div>
	<?php endif; ?>
	<blockquote>
        <?php echo nl2br(Text::urlink($post->text)); ?>
        <?php if ($this['show'] == 'list') : ?><div class="read_more"><a href="<?php echo $url.$post->id; ?>"><?php echo Text::get('regular-read_more') ?></a></div><?php endif ?>
    </blockquote>
