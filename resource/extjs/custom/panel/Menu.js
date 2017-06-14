Ext.define('Ext.panel.Menu',{
    extend:'Ext.panel.Panel',
    border:false,
    frame:false,
    openedClass:[],
    initComponent:function(){
        var menu = this;
        var store = Ext.create('Ext.data.TreeStore', {
            root: {
                expanded: true,
                children: [
                    // { text: "账号管理", expanded: true, children: [
                        { text: "账号资料", leaf: true }   ,
                    // ] },
                    {text: "价格提醒", leaf: true, class : 'Ext.panel.PriceWarn'},
                    {text: "委托队列", leaf: true, class : 'Ext.panel.EntrustList'},
                ]
            }
        });

        this.items = Ext.create('Ext.tree.Panel', {
            width: 200,
            height: 150,
            border:false,
            frame:false,
            store: store,
            rootVisible: false,
            listeners:{
                itemclick:function(node, record, item) {
                    var tab = node.up('viewport').down('tabpanel');
                    if(!record.raw.class) return;
                    var openId = menu.getOpenId(record.raw.class);
                    if (openId === -1) {
                        var id = Ext.id();
                        var panel = Ext.create(record.raw.class,{
                            title:record.raw.text,
                            closable : true,
                            id:id,
                            listeners:{
                                close:function( panel, eOpts ){
                                   delete menu.openedClass[panel.__proto__.$className];
                                }
                            }
                        })
                        tab.add(panel);
                        tab.setActiveTab(panel);
                        menu.openedClass[record.raw.class] = id;
                    } else {
                        tab.setActiveTab(Ext.getCmp(openId));
                    }
                }

            }
        });
        this.callParent(arguments);
    },
    getOpenId:function(className){
        if((typeof this.openedClass[className]) == 'undefined') {
            return -1;
        }
        return this.openedClass[className];
    }
});
