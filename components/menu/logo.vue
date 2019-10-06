<template>
    <div class="box">
        <span>SHOPPANEL</span>
        <i class="shopicon"><a-icon class="shopIcon" type="shopping-cart" /></i>
        <i class="logout"><a-icon type="login" /></i>
    </div>
</template>


<style scoped>
    div.box{
        background: #fff;
        height: 45px;
        text-align: left;
        color: #333;
        position: relative;
    }
    div.box i.shopicon{
        font-size: 30px;
        position: relative;
        top: -8px;
        left: 15px;
    }
    i.logout{
        position: absolute;
        top:1px;
        font-size: 20px;
        right: 15px;
        cursor: pointer;
        color: #888;
    }
    i.logout:hover{
        color: #000;
    }
    div.box span{
        position: relative;
        top: -5px;
        left: 20px;
        font-size: 18px;
        font-family: Arial,serif;
        font-weight: bold;

    }
</style>