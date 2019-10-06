<template>
    <div>

        <div class="navBox"></div>
        <div class="contentBox">

            <div class="fixed">

               <slot></slot>

            </div>

        </div>

    </div>
</template>


<style >
    div.contentBox {
        position: fixed;
        overflow: auto;
        height: 100vh;
        background: #ccc;
        width: calc(100% - 280px);
        top: 0;
        right: 0;
    }
    div.navBox{
        height: 45px;
        position: fixed;
        background: #eee;
        width: calc(100% - 280px);
        z-index: 4;
        top: 0;
        right: 0;
    }
    div.fixed{
        padding: 50px 20px 20px 20px;
    }
</style>

