<template>
 <div>
   <basemenu/>
   <contentBox>

       <div class="boxItem">
           <h1 class="title">لیست کالا ها</h1>

           <div class="ltr">
                    <a-table size="small" @change="onChange" :columns="columns" :pagination="pagination" :dataSource="data"
                             :loading="loading" :scroll="{ x: 1000}">
                        <p slot="action" slot-scope="record">
                            <nuxt-link v-bind:to="'/panel/product?id='+record.rowId" class="Lnkk">ویرایش</nuxt-link>
                            <span>/</span>
                            <span v-on:click="removeProduct(record.rowId)" class="Lnkk">حذف</span>
                        </p>
                    </a-table>
                </div>

      </div>

   </contentBox>
 </div>
</template>
<script>

  import basemenu from '../../../components/menu/basemenu'
  import contentBox from '../../../components/content/index'
  import { mapState } from "vuex"

  const columns = [
      {title: 'محصول', dataIndex: 'title', key: 'title'},
      {title: 'وضعیت', dataIndex: 'state', key: 'state'},
      {title: 'تنوع کالا', dataIndex: 'productTotal', key: 'productTotal'},
      {title: 'وضعیت در باشگاه', dataIndex: 'stateClub', key: 'stateClub'},
      {title: ' تعداد عکس ها', dataIndex: 'imagesTotal', key: 'imagesTotal'},
      {
          title: 'عملیات',
          key: 'operation',
          fixed: 'right',
          width: 150,
          scopedSlots: {customRender: 'action'},
      },
  ];

  export default {
      computed: {
          ...mapState([
              'LastFileUpload'
          ]),
      },
      data() {
          return {
              pagination: {
                  pageSize: 20,
                  current: 1,
                  total: 0
              },
              loading: false,
              data: [],
              columns,
          }
      },
      components: {
          basemenu,
          contentBox,

      },
      methods:{
          removeProduct(id){
              var r = confirm("آیا میخواهید این محصول را از لیست پاک کنید؟");
              if (r == true) {

                  this.$axios.post('Products/remove', {
                      id: id,
                  },{}).then(resp => {
                      this.getList();
                      this.loading = false;
                  });


              }else{

              }
          },
          getList() {

              this.$axios.post('Products/getlist', {
                  page: this.pagination.current,
                  pageSize: this.pagination.pageSize
              }, {
                  headers: {
                      'token':""
                  }
              }).then(resp => {
                  console.log(resp.data.list);
                  this.data = resp.data.list;
                  this.pagination.total = resp.data.num_rows;
                  this.loading = false;
              });

          },
          onChange(pagination, filters, sorter) {
              this.pagination.current = pagination.current;
              this.getList();
          }
      },
      mounted() {
          this.getList();
      }

  }

</script>
<style scoped>
    .Lnkk{
        color: #555;
        background: #eee;
        padding: 4px 10px;
        display: inline-block;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
    }
    .Lnkk:hover{
        background: #b9926d;
        color: #fff;
    }

</style>
