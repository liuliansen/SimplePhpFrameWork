Ext.define('Ext.panel.EntrustList',{
    extend:'Ext.panel.Panel',
    layout: 'border',
    border:false,
    frame:false,

    initComponent:function(){
        var pricePanel = this;
        pricePanel.items = [
            {
                xtype:'grid',
                region:'center',
                border:false,
                frame:false,
                store:Ext.create('Ext.data.Store',{
                    //{"addtime":"05-20 14:50:43","type":"1","price":25.2,"num":1,"deal":0,"id":88393},
                    fields:[
                        {name:'type'},
                        {name:'typeText'},
                        {name:'addtime'},
                        {name:'price'},
                        {name:'num'},
                        {name:'deal'},
                        {name:'amount'},
                        {name:'entrust_id'},
                    ],
                    autoLoad:true,
                    proxy:{
                        type:'ajax',
                        url: JsHelper.buildUrl(HOST,RQ,'Entrust','getEntrustList'),
                        reader: {
                            type: 'json',
                            root: 'entrust_list'
                        }
                    }
                }),
                columns: [
                    { text: '委托时间',  dataIndex: 'addtime',width:'20%' },
                    { text: '买/卖', dataIndex: 'typeText', width:'20%' },
                    { text: '委托价格', dataIndex: 'price', width:'20%' },
                    { text: '委托数量', dataIndex: 'num', width:'20%' },
                    { text: '已成交数量', dataIndex: 'deal' ,flex: 1 },
                    { text: '委托金额', dataIndex: 'amount' ,flex: 1 },
                    {  xtype:'actioncolumn', text:'操作', hideable : false,sortable :false,items:[{
                        icon: HOST+'/resource/images/delete.png',  // Use a URL in the icon config
                        tooltip: 'Edit',
                        handler: function(grid, rowIndex, colIndex) {

                        }}]
                    }
                ],
            }

        ];





        pricePanel.callParent(arguments);
    }
});