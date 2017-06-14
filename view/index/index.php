<?php
use includes\App;
$httpRoot = App::getConf('httpRoot');
$rq = App::getConf('routeParam');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>管理</title>
<link href="<?=$httpRoot?>/resource/css/ext-theme-neptune/ext-theme-neptune-all.css" rel="stylesheet">
<!--    <script src="--><?//=$httpRoot?><!--/resource/js/jquery-1.9.1.min.js"></script>-->
<script src="<?=$httpRoot?>/resource/extjs/ext-all.js"></script>
<script src="<?=$httpRoot?>/resource/extjs/ext-lang-zh_CN.js"></script>
<script src="<?=$httpRoot?>/resource/js/common.js"></script>
<script>
HOST = '<?=$httpRoot?>';
RQ = '<?=$rq?>';
Ext.Loader.setConfig({
    enabled:true,
    paths:{
        'Ext': '<?=$httpRoot?>/resource/extjs/custom'
    }
});
Ext.application({
  name:'kz_d3zz',
  launch:function(){
      Ext.create('Ext.container.Viewport', {
          layout: 'border',
          items: [{
              region: 'north',
              bodyStyle:'background:#DBF8FF;',
              html: '<h1 class="x-panel-header" style="margin-left: 30px;">监控</h1>',
              border: false,
              margins: '0 0 5 0'
          }, {
              region: 'west',
              collapsible: true,
              title: '功能菜单',
              split:true,
              width: 200,
              items: Ext.create('Ext.panel.Menu',{

              })
          },{
              region: 'center',
              xtype : 'tabpanel',

              activeTab: 0,
              items: Ext.create('Ext.panel.HomePage',{
                  title:'日常数据'
              })
          }]
      });
  }
});
</script>
</head>
<body>
</body>
</html>