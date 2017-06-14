Ext.define('Ext.panel.PriceWarn',{
    extend:'Ext.panel.Panel',
    layout: 'border',
    border:false,
    frame:false,

    initComponent:function(){
        var pricePanel = this;

        pricePanel.items = [
            {
                xtype:'form',
                border:false,
                frame:false,
                region:'north',
                height:'30%',
            },
            {
                xtype:'grid',
                region:'center',
                border:false,
                frame:false,
                columns: [
                    { text: '成交时间',  dataIndex: 'name',width:'20%' },
                    { text: '买/卖', dataIndex: 'email', width:'20%' },
                    { text: '价格', dataIndex: 'phone', width:'20%'},
                    { text: '数量', dataIndex: 'phone', width:'20%' },
                    { text: '金额', dataIndex: 'phone' ,flex: 1 },
                ],
            }

        ];





        pricePanel.callParent(arguments);
    }
});