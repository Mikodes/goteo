<?php
use Goteo\Core\View,
    Goteo\Library\Text,
    Goteo\Model\Project;

$project = $this['project'];

if (!$project instanceof  Goteo\Model\Project) {
    return;
}
?>
<div class="widget">
    <p><strong><?php echo $project->name ?></strong></p>
    <a class="button red" href="/project/edit/<?php echo $project->id ?>"><?php echo Text::get('regular-edit') ?></a>
    <a class="button" href="/project/<?php echo $project->id ?>" target="_blank"><?php echo Text::get('dashboard-menu-projects-preview') ?></a>
    <?php if ($project->status <= 1) : ?>
    <a class="button weak" href="/project/delete/<?php echo $project->id ?>" onclick="return confirm('<?php echo Text::get('dashboard-project-delete_alert') ?>')"><?php echo Text::get('regular-delete') ?></a>
    <?php endif ?>
</div>

<div class="status">

    <div id="project-status" style="width: 280px;">
        <h3><?php echo Text::get('form-project-status-title'); ?></h3>
        <ul>
            <?php foreach (Project::status() as $i => $s): ?>
            <li><?php if ($i == $project->status) echo '<strong>' ?><?php echo htmlspecialchars($s) ?><?php if ($i == $project->status) echo '</strong>' ?></li>
            <?php endforeach ?>
        </ul>
    </div>

</div>

<div id="meter-big" class="widget collapsable">

    <?php echo new View('view/project/meter_hor_big.html.php', $this) ?>
    
</div>

<br clear="both" />
<br />

<?php if (in_array($project->status, array(3, 4, 5))) : ?>
<!-- librerias externas -->
<!--    <script language="javascript" type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>  -->
    <script language="javascript" type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/d3/3.0.8/d3.min.js"></script>
    <script language="javascript" type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.4.4/underscore-min.js"></script>
    <script language="javascript" type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.min.js"></script>

    <!-- funciones para la visualización -->
    <script language="javascript" type="text/javascript" src="/view/js/project/chart.js"></script>
    <script language="javascript" type="text/javascript" src="/view/js/project/visualizers.js"></script>
    <script language="javascript" type="text/javascript" src="/view/js/project/display.js"></script>

    <!-- estilos para la visualización -->
    <link rel="stylesheet" type="text/css" href="/view/css/dashboard/projects/graph.css"/>	
    
    
    
    <div class="widget chart"> 
            <div id="project_selection" style="margin-bottom: 10px"></div>
            <div class="titles">
                <div>
                    <h2>FINANCIACI&OacuteN OBTENIDA</h2>
                    <div id="funded" class="obtenido number"></div>
                    <div id="de" class="de"></div>
                    <div id="minimum" class="minimum number"></div>
                    <div id="euros" class="euros"></div>
                </div>
                <div class="quedan">
                    <div style="font-weight: normal; font-size: 12px">QUEDAN<h2 id="dias" style="display:inline"></h2>D&IacuteAS</div>
                </div>
            </div>
            <div id="funds" class="chart_div"></div>
            <div>
                <h2>COFINANCIADORES</h2>
            </div>
            <div id="cofund" class="chart_div"></div>
    </div>
    
<script type="text/javascript">
    /* función para cargar los datos del gáfico, sacado de graphA.js */
jQuery(document).ready(function(){
        GOTEO.initializeGraph(<?php echo $this['data']; ?>); 
    });

</script>
<?php endif; ?>
<div class="widget projects">
    <h2 class="widget-title title"><?php echo Text::get('project-spread-widget_title'); ?></h2>
    <?php echo new View('view/project/widget/embed.html.php', array('project'=>$project)) ?>
</div>
