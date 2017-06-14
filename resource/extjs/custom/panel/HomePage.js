Ext.define('Ext.panel.HomePage',{
    extend:'Ext.panel.Panel',
    layout: 'border',
    border:false,
    frame:false,


    initComponent:function(){

        this.items = [
            Ext.create('Ext.tab.BuyAndSale',{
                region:'east',
                width:450,
                split:true
            }),{
                region:'center',
                layout:'border',
                border:false,
                frame:false,
                items: [{
                    region:'center',
                    border:false,
                    frame:false,
                    listeners: {
                        resize: function (panel, width, height) {
                            panel.down('chart').setWidth(width);
                            panel.down('chart').setHeight(height);
                        },
                        afterrender: function (panel, eOpts) {
                            var store = Ext.create('Ext.data.Store', {
                                fields: [
                                    {name: 'date'},
                                    {name: 'value'},
                                ],

                                data:[
                                    {date:'05-22',value:12},
                                    {date:'05-22',value:13},
                                    {date:'05-22',value:14},
                                    {date:'05-22',value:15},
                                    {date:'05-22',value:14},
                                    {date:'05-22',value:13},
                                ],


                                // proxy:{
                                //     type: 'ajax',
                                //     url: JsHelper.buildUrl(HOST, RQ,'index','getDailyAvgPrice'),
                                //     reader: {
                                //         type: 'json',
                                //         root: 'data'
                                //     }
                                // },
                                // listeners:{
                                //     load:function(){
                                //         setTimeout(function(){store.load();},1500);
                                //     }
                                // },
                                autoLoad: true
                            });



                            panel.add(
                            Ext.create('Ext.chart.Chart', {
                                animate: true,
                                shadow: true,
                                store: store,
                                axes: [{
                                    type: 'Numeric',
                                    position: 'left',
                                    fields: ['value'],
                                    title: false,
                                    grid: true
                                }, {
                                    type: 'Category',
                                    position: 'bottom',
                                    fields: ['date'],
                                    title: false
                                }],
                                series: [{
                                    type: 'line',
                                    axis: 'left',
                                    gutter: 80,
                                    xField: 'date',
                                    yField: ['value'],
                                    // tips: {
                                    //     trackMouse: true,
                                    //     width: 580,
                                    //     height: 170,
                                    //     layout: 'fit',
                                    //     items: {
                                    //         xtype: 'container',
                                    //         layout: 'hbox',
                                    //         items: []
                                    //     },
                                    //     renderer: function(klass, item) {
                                    //         var storeItem = item.storeItem,
                                    //             data = [{
                                    //                 name: 'data1',
                                    //                 data: storeItem.get('data1')
                                    //             }, {
                                    //                 name: 'data2',
                                    //                 data: storeItem.get('data2')
                                    //             }, {
                                    //                 name: 'data3',
                                    //                 data: storeItem.get('data3')
                                    //             }, {
                                    //                 name: 'data4',
                                    //                 data: storeItem.get('data4')
                                    //             }, {
                                    //                 name: 'data5',
                                    //                 data: storeItem.get('data5')
                                    //             }], i, l, html;
                                    //
                                    //         this.setTitle("Information for " + storeItem.get('name'));
                                    //         pieStore.loadData(data);
                                    //         gridStore.loadData(data);
                                    //         grid.setSize(480, 130);
                                    //     }
                                    // }
                                }]
                            })

                            //     Ext.create('Ext.chart.Chart', {
                            //     style: 'background:#fff',
                            //     animate: true,
                            //     theme: 'Sky',
                            //     store: store,
                            //     width: this.up('viewport').getWidth() - 650,
                            //     height: 300,
                            //     axes: [{
                            //         type: 'Numeric',
                            //         position: 'left',
                            //         fields: ['value'],
                            //         grid: true
                            //     }, {
                            //         type: 'Category',
                            //         position: 'bottom',
                            //         fields: ['date'],
                            //         title: '交易均价图',
                            //         grid: true,
                            //         label: {
                            //             rotate: {
                            //                 degrees: 330
                            //             }
                            //         }
                            //     }],
                            //     series: [{
                            //         type: 'column',
                            //         axis: 'left',
                            //         xField: 'date',
                            //         yField: 'value',
                            //         markerConfig: {
                            //             type: 'line'
                            //         }
                            //     }, {
                            //         type: 'line',
                            //         axis: 'left',
                            //         smooth: true,
                            //         fill: true,
                            //         fillOpacity: 0.7,
                            //         xField: 'date',
                            //         yField: 'value',
                            //         listeners: {
                            //             show: function () {
                            //                 console.log(arguments);
                            //             }
                            //         }
                            //     }]
                            // })

                            );
                        }
                    }
                },{
                    region: 'south',
                    height: '70%',
                    border: false,
                    frame : false,
                    layout: 'border',
                    items:  [
                        Ext.create('Ext.form.Top',{
                            region:'north',
                            height:40
                        }),
                        Ext.create('Ext.panel.TradeLog')]

                }]
            }
        ];

        this.callParent(arguments);
    }
});