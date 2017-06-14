Ext.define('Ext.panel.TradeLog',{
    extend:'Ext.panel.Panel',
    layout:'border',
    region:'center',
    border:false,
    frame: false,
    store:Ext.create('Ext.store.TradeLog'),
    getData:function(){
        var _this = this;
        _this.store.load({
            callback:function(){
                setTimeout(function(){_this.getData();},1500);
            }
        });
    },
    initComponent:function(){
        var _this = this;
        _this.getData();
        _this.items = {
            border:false,
                frame:false,
                xtype:'grid',
                region:'center',
                store: _this.store,
                viewConfig : {
                loadMask : false
            },
            autoScroll : true,
                columns: [
                { text: '成交时间',  dataIndex: 'addtime',hideable : false,sortable :false,width:'20%' },
                { text: '买/卖', dataIndex: 'typeText', hideable : false,sortable :false,width:'20%' },
                { text: '价格', dataIndex: 'price', align:'right',hideable : false,sortable :false,width:'20%'},
                { text: '数量', dataIndex: 'quantity', align:'right',hideable : false,sortable :false,width:'20%' },
                { text: '金额', dataIndex: 'amount' ,align:'right',hideable : false,sortable :false,flex: 1 },
            ]
        }
        _this.callParent();
    }

});