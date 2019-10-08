<template>
 <div>
   <basemenu/>
   <contentBox>

       <div class="boxItem">
           <h1 class="title">مشخصات کالا
            <div v-if="frm.rowId" class="editRow">بروزرسانی کد : {{frm.rowId}}</div>
           </h1>


           <div class="row">

               <div class="col-md-12">
                   <div class="row">
                       <div class="col-lg-2"><label>نام کالا</label></div>
                       <div class="col-lg-4"><input v-model="frm.title" class="_fild"/></div>

                       <div class="col-lg-2"><label>فعال در باشگاه</label></div>
                       <div class="col-lg-1"> <a-switch v-model="frm.stateClub" /></div>

                       <div class="col-lg-1"><label>وضعیت</label></div>
                       <div class="col-lg-1"> <a-switch v-model="frm.state" /></div>

                       <div class="col-12"><div class="hr"></div></div>
                       <div class="col-lg-2"><label>توضیحات </label></div>
                       <div class="col-lg-10"><vue-editor id="editor" v-model="frm.description" :editorToolbar="customToolbar"></vue-editor></div>
                       <div class="col-12"><div class="hr"></div></div>
                   </div>
               </div>

                <div class="col-12"><div class="hr"></div></div>
               <div class="col-md-10"></div>
               <div class="col-md-2">
                   <button v-if="!loading" v-on:click="save" class="btnsuccess">ذخیره</button>
                   <button v-if="loading" class="btnsuccess"><a-icon type="loading" /></button>
               </div>

           </div>

            </div>


       <div class="boxItem">
           <h1 class="title">قیمت ها</h1>


           <div class="ltr pad10">
               <a-alert
                       message="در صورتی که میخواهید یک قیمت را حذف کنید لطفا کد محصول آن را خالی رها کنید"
                       type="warning"
               />
           </div>

           <div v-for="n in frm.product" class="row">

                <div class="col-lg-2">
                    <label><a-icon type="caret-down"/><span>کد محصول</span> </label>
                    <input v-on:keydown="addFildprice" v-model="n.code" class="_fild"/>
                </div>

               <div class="col-lg-3">
                    <label><a-icon type="caret-down"/> <span>رنگ</span> </label>
                    <select v-if="colors"  v-model="n.color" class="_fild">
                        <option v-for="n in colors">{{n.title}}</option>
                    </select>
                </div>

               <div class="col-lg-2">
                    <label><a-icon type="caret-down"/> <span>قیمت اصلی</span> </label>
                    <input  v-model="n.price" class="_fild"/>
                </div>

               <div class="col-lg-2">
                    <label><a-icon type="caret-down"/> <span>قیمت با تخفیف</span> </label>
                    <input  v-model="n.discountedPrices" class="_fild"/>
                </div>

               <div class="col-lg-2">
                    <label><a-icon type="caret-down"/> <span>قیمت باشگاه</span> </label>
                    <input  v-model="n.clubPrices" class="_fild"/>
                </div>


                <div class="col-12"><div class="hrLine"></div></div>

           </div>

       </div>

       <div class="boxItem">
           <h1 class="title">گالری تصاویر</h1>
           <div class="row">


               <div class="col-md-12">

                   <FileUpload category="product"/>

               </div>

               <div class="col-md-12">

                   <div class="ltr pad10">
                       <a-alert
                               v-if="frm.images.length==0"
                               message="هیچ تصویری برای این محصول وجود ندارد"
                               type="warning"
                       />

                       <div>
                           <div class="row">
                               <div  v-for="rw in frm.images" class="col-lg-3 col-md-4 col-sm-6">
                                   <div v-bind:class="{active:rw.showFirst}" v-on:click="setFirstImg(rw.id)" class="_img_"><img v-bind:src="rw.img"></div>
                               </div>
                           </div>
                       </div>


                   </div>

               </div>



           </div>
       </div>


   </contentBox>
 </div>
</template>
<script>

  import {VueEditor} from "vue2-editor";
  import basemenu from '../../../components/menu/basemenu'
  import contentBox from '../../../components/content/index'
  import FileUpload from '../../../components/uploadFile/index'
  import { mapState } from "vuex"

  export default {
      computed: {
          ...mapState([
              'LastFileUpload'
          ]),
      },
      data() {
          return {
              loading:false,

              frm:{
                  rowId:0,
                  title:"",
                  description:"",
                  state:true,
                  stateClub:false,
                  product: [
                      {code: "", color: "", price: "", discountedPrices: "", clubPrices: ""}
                  ],
                  images:[]
              },
              colors: [],
              customToolbar: [["bold", "italic", "underline"], [{list: "ordered"}, {list: "bullet"}], ["code-block"]]
          }
      },
      watch:{
          'LastFileUpload':function (val) {
              this.frm.images.push({id:val.id,img:val.file,showFirst:false})

          }
      },
      components: {
          basemenu,
          contentBox,
          VueEditor,
          FileUpload

      },
      methods:{
          addFildprice  :function () {

              if (this.frm.product.length) {
                  if (this.frm.product[this.frm.product.length - 1].code.length>=1){
                      this.frm.product.push({code: "", color: "", price: "", discountedPrices: "", clubPrices: ""});
                  }
              }

          },
          setFirstImg:function (id) {

              this.frm.images.forEach(function (item) {

                  if (item.id==id){
                      item.showFirst = true;
                  }else{
                      item.showFirst = false;
                  }

              });

          },
          getColor() {
              this.$axios.post('Tools/getColors', {}).then(response => {
                  this.colors = response.data.list;
              }).catch((error) => {
                  console.log('error 3 ' + error);
              });
          },
          save() {
              this.loading = true;
              this.$axios.post('Products/set', this.frm).then(response => {

                  this.frm.rowId = response.data.insert_id;
                  this.loading = false;

              }).catch((error) => {
                  console.log('error 3 ' + error);
                  this.loading = false;
              });
          },
          get() {
              this.loading = true;
              this.$axios.post('Products/getone', {
                  'id' :this.$route.query.id
              }).then(response => {

                  this.frm = response.data.row;
                  this.loading = false;

              }).catch((error) => {
                  console.log('error 3 ' + error);
                  this.loading = false;
              });
          },
      },
      mounted() {
          this.getColor();
          if (this.$route.query.id) this.get();

      }

  }

</script>
<style scoped>
    ._img_.active{
        background: #e4f9eb;
        border-color: #69b783;
    }
    div.itemReport {
        background: #b9926d;
        padding: 10px;
        min-height: 80px;
        width: 100%;
        margin-bottom: 20px;
        border-radius: 4px;
        direction: rtl;
        text-align: right;
        color: #fff;
        font-family: IRANSansWeb_Bold, serif;
    }


    div.itemReport div.title {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 5px;
    }

    div.itemReport div.title svg {
        display: inline-block;
        margin-left: 10px;
        font-size: 11px;
        position: relative;
        top: -4px;

    }
    div._img_{
        margin: 10px;
        text-align: center;
        padding: 20px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    div._img_ img{
        max-width: calc(100% - 20px);
        margin: 10px;
        max-height: 200px;
    }

    div.editRow{
        float: left;
        font-size: 13px;
        background: #e1fae5;
        color: #0b5818;
        padding: 4px 10px;
        border-radius: 5px;
        position: relative;
        top: -5px;
    }
    div.itemReport div.num {
        font-size: 25px;
        color: #000;
        padding-top: 5px;
        text-align: center;
    }
</style>
