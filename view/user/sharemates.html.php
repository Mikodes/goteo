<?php

use Goteo\Core\View,
    Goteo\Library\Worth,
    Goteo\Library\Text,
    Goteo\Model\User\Interest,
    Goteo\Core\Redirection;

$bodyClass = 'user-profile';
include 'view/prologue.html.php';
include 'view/header.html.php';

$user = $this['user'];
$worthcracy = Worth::getAll();

$categories = Interest::getAll($user->id);

$shares = array();
/* if (!empty($this['category'])) {
    $shares[$this['category']->id] = Interest::share($user->id, $this['category']->id);
} else { */
    foreach ($categories as $catId => $catName) {
        $gente = Interest::share($user->id, $catId);
        if (count($gente) == 0) continue;
        $shares[$catId] = $gente;
    }
//}

if (count($shares) == 0) {
    throw new Redirection('/user/profile/' . $this['user']->id);
}

?>
<div id="sub-header">
    <div>
        <h2><a href="/user/<?php echo $user->id; ?>"><img src="<?php echo SRC_URL ?>/image/<?php echo $user->avatar->id; ?>/75/75/1" /></a> <?php echo Text::get('profile-name-header'); ?> <br /><em><?php echo $user->name; ?></em></h2>
    </div>
</div>

<div id="main">

    <div class="center">
       
       
       <!-- lista de categorías -->
        <div class="widget categorylist">
            <h3 class="title"><?php echo Text::get('profile-sharing_interests-header');?></h3>
			<!--
            <div class="filters">
                <span>Ver por:</span>
                <ul>
                    <li><a href="#" class="active">Por categorías</a></li>
                    <li class="separator">|</li>
                    <li><a href="#">Por tags</a></li>                
                </ul>
            </div>
			-->
            <script type="text/javascript">
            function displayCategory(categoryId){
                $(".user-mates").css("display","none");
                $("#cat" + categoryId).fadeIn("slow");
                $(".active").removeClass('active');
                $("#catlist" + categoryId).addClass('active');
            }
            </script>
            <div class="list">
                <ul>
                    <?php foreach ($categories as $catId=>$catName) : if (count($shares[$catId]) == 0) continue; ?>
                    <li><a id="catlist<?php echo $catId ?>" href="/user/profile/<?php echo $this['user']->id ?>/sharemates/<?php echo $catId ?>" <?php if (!empty($this['category'])) : ?>onclick="displayCategory(<?php echo $catId ?>); return false;"<?php endif; ?> <?php if ($catId == $this['category']) echo 'class="active"'?>><?php echo $catName ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <!-- fin lista de categorías -->
        
        <!-- detalle de categoría (cabecera de categoría) -->
        <?php foreach ($shares as $catId => $sharemates) :
            if (count($sharemates) == 0) continue;
            ?>
            <div class="widget user-mates" id="cat<?php echo $catId;?>" <?php if (!empty($this['category']) && $catId != $this['category']) echo 'style="display:none;"'?>>
                <h3 class="title"><?php echo $categories[$catId] ?></h3>
                <div class="users">
                    <ul>
                    <?php 
                    $cnt = 1;
                    foreach ($sharemates as $mate) :
                        if (empty($this['category']) && $cnt > 6) break;
                    ?>
                        <li class="<?php if($cnt < 3) echo " bordertop"?>">
                            <div class="user">
                                <a href="/user/<?php echo htmlspecialchars($mate->user) ?>" class="expand">&nbsp;</a>
                                <div class="avatar"><a href="/user/<?php echo htmlspecialchars($mate->user) ?>"><img src="<?php echo SRC_URL ?>/image/<?php echo $mate->avatar->id ?>/43/43/1" /></a></div>
                                <h4><a href="/user/<?php echo htmlspecialchars($mate->user) ?>"><?php echo htmlspecialchars($mate->name) ?></a></h4>
                                <span class="projects"><?php echo Text::get('regular-projects'); ?> (<?php echo $mate->projects ?>)</span>
                                <span class="invests"><?php echo Text::get('regular-investing'); ?> (<?php echo $mate->invests ?>)</span><br/>
                                <span class="profile"><a href="/user/<?php echo htmlspecialchars($mate->user) ?>">Ver perfil</a> </span>
                                <span class="contact"><a href="/user/profile/<?php echo htmlspecialchars($mate->user) ?>/message">Escribir mensaje</a></span>
                            </div>
                        </li>
                    <?php 
                    $cnt ++;
                    endforeach; ?>
                    </ul>
                </div>
        <?php if (empty($this['category'])) : ?>
            <a class="more" href="/user/profile/<?php echo $this['user']->id ?>/sharemates/<?php echo $catId ?>"><?php echo Text::get('regular-see_more'); ?></a>
        <?php else : ?>
            <a class="more" href="/user/profile/<?php echo $this['user']->id ?>/sharemates"><?php echo Text::get('regular-see_all'); ?></a>
        <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <!-- fin detalle de categoría (cabecera de categoría) -->
        
    </div>
    <div class="side">
        <?php if (!empty($_SESSION['user'])) echo new View('view/user/widget/investors.html.php', $this) ?>
        <?php echo new View('view/user/widget/user.html.php', $this) ?>
    </div>

</div>

<?php include 'view/footer.html.php' ?>

<?php include 'view/epilogue.html.php' ?>
