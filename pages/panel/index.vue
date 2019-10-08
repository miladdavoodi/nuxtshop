<template>
 <div>
   <basemenu/>
   <contentBox>

       <div class="row">
           <div class="col-md-3 col-sm-6" v-for="n in 4">
               <div class="itemReport">
                   <div class="title">
                       <a-icon type="double-left" />
                       <span>تعداد کاربران</span>
                   </div>
                   <div class="num">5,446</div>
               </div>
           </div>
       </div>

       <div class="boxItem">
           <apexchart type=line height=350 :options="chartOptions" :series="series" />
       </div>

       <div class="boxItem">

            <a-table :columns="columns" :dataSource="data" bordered>
                <template slot="name" slot-scope="text">
                  <a href="javascript:;">{{text}}</a>
                </template>
                <template slot="title" slot-scope="currentPageData">
                   <div class="_title">آخرین سفارشات فروشگاه</div>
                </template>
              </a-table>

       </div>

   </contentBox>
 </div>
</template>
<script>

  import basemenu from '../../components/menu/basemenu'
  import contentBox from '../../components/content/index'
  import VueApexCharts from 'vue-apexcharts'

  const columns = [{
      title: 'Name',
      dataIndex: 'name',
      scopedSlots: { customRender: 'name' },
  }, {
      title: 'Cash Assets',
      className: 'column-money',
      dataIndex: 'money',
  }, {
      title: 'Address',
      dataIndex: 'address',
  }];

  const data = [{
      key: '1',
      name: 'John Brown',
      money: '￥300,000.00',
      address: 'New York No. 1 Lake Park',
  }, {
      key: '2',
      name: 'Jim Green',
      money: '￥1,256,000.00',
      address: 'London No. 1 Lake Park',
  }, {
      key: '3',
      name: 'Joe Black',
      money: '￥120,000.00',
      address: 'Sidney No. 1 Lake Park',
  }];


  export default {
      components: {
          basemenu,
          contentBox,
          apexchart: VueApexCharts,
      },
      data: function() {
          return {
              data,
              columns,
              series: [{
                  name: 'TEAM A',
                  type: 'column',
                  data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
              }, {
                  name: 'TEAM B',
                  type: 'area',
                  data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
              }, {
                  name: 'TEAM C',
                  type: 'line',
                  data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
              }],
              chartOptions: {
                  chart: {
                      stacked: false,
                  },
                  stroke: {
                      width: [0, 2, 5],
                      curve: 'smooth'
                  },
                  plotOptions: {
                      bar: {
                          columnWidth: '50%'
                      }
                  },

                  fill: {
                      opacity: [0.85, 0.25, 1],
                      gradient: {
                          inverseColors: false,
                          shade: 'light',
                          type: "vertical",
                          opacityFrom: 0.85,
                          opacityTo: 0.55,
                          stops: [0, 100, 100, 100]
                      }
                  },
                  labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003',
                      '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'
                  ],
                  markers: {
                      size: 0
                  },
                  xaxis: {
                      type: 'datetime'
                  },
                  yaxis: {
                      title: {
                          text: 'Points',
                      },
                      min: 0
                  },
                  tooltip: {
                      shared: true,
                      intersect: false,
                      y: {
                          formatter: function (y) {
                              if (typeof y !== "undefined") {
                                  return y.toFixed(0) + " points";
                              }
                              return y;

                          }
                      }
                  }
              }
          }
      },
  }
</script>
<style scoped>
    div.itemReport{
        background: #b9926d;
        padding: 10px;
        min-height: 80px;
        width: 100%;
        margin-bottom: 20px;
        border-radius: 4px;
        direction: rtl;
        text-align: right;
        color: #fff;
        font-family: IRANSansWeb_Bold,serif;
    }
    div.itemReport div.title{
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 5px;
    }
    div.itemReport div.title svg{
        display: inline-block;
        margin-left: 10px;
        font-size: 11px;
        position: relative;
        top: -4px;

    }
    div.itemReport div.num{
        font-size: 25px;
        color: #000;
        padding-top: 5px;
        text-align: center;
    }
</style>
