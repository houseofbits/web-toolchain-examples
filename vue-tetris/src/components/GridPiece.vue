<template>
    <div :class="pieceClass" :style="pieceStyle" />
</template>

<script>
    export default {
        name: "GridPiece",
        props: ['posX', 'posY', 'size', 'color', 'clear'],
        computed:{
            pieceClass:function(){
                let clear = ((this.clear)?' clear':'');
                return 'piece color'+(this.color - 1) + clear;
            },
            pieceStyle:function(){
                return {
                    width:this.size + 'px',
                    height:this.size + 'px',
                    top:(this.posY * this.size)+ 'px',
                    left:(this.posX * this.size) + 'px',
                }
            }
        }
    }
</script>

<style scoped>
    .piece{
        position: absolute;
        border: solid 3px black;
        box-sizing: border-box;
        border-left-color: rgba(255,255,255,0.5);
        border-top-color: rgba(255,255,255,0.5);
        border-right-color: rgba(0,0,0,0.4);
        border-bottom-color: rgba(0,0,0,0.4);
        border-radius: 5px;
    }
    .clear{
        opacity: 0;
        transition: opacity 1s;
    }
    .color0{
        background-color: cyan;
        background: linear-gradient(to right, rgba(147,206,222,1) 0%, rgba(117,189,209,1) 41%, rgba(73,165,191,1) 100%);
    }
    .color1{
        background-color: blue;
        background: linear-gradient(to right, rgba(73,155,234,1) 0%, rgba(32,124,229,1) 100%);
    }
    .color2{
        background-color: orange;
        background: linear-gradient(to right, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
    }
    .color3{
        background-color: yellow;
        background: linear-gradient(to right, rgba(241,231,103,1) 0%, rgba(254,182,69,1) 100%);
    }
    .color4{
        background-color: green;
        background: linear-gradient(to right, rgba(164,179,87,1) 0%, rgba(117,137,12,1) 100%);
    }
    .color5{
        background-color: magenta;
        background: linear-gradient(to right, rgba(255,93,177,1) 0%, rgba(239,1,124,1) 100%);
    }
    .color6{
        background-color: red;
        background: linear-gradient(to right, rgba(241,111,92,1) 0%, rgba(231,56,39,1) 100%);
    }
    .color7{
        background-color: darkgray;
        background: linear-gradient(to right, #7d7e7d 0%,#0e0e0e 100%);
    }
    .color8{
        background-color: darkred;
        background: linear-gradient(to right, #a90329 0%,#8f0222 44%,#6d0019 100%);
    }
</style>