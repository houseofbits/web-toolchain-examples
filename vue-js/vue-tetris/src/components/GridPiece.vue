<template>
    <div :class="pieceClass" :style="pieceStyle" />
</template>

<script>
    export default {
        name: "GridPiece",
        props: ['posX', 'posY', 'size', 'color'],
        computed:{
            pieceClass:function(){
                return 'piece color'+(this.color - 1);
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
    .color0{
        background-color: cyan;
    }
    .color1{
        background-color: blue;
    }
    .color2{
        background-color: orange;
    }
    .color3{
        background-color: yellow;
    }
    .color4{
        background-color: green;
    }
    .color5{
        background-color: magenta;
    }
    .color6{
        background-color: red;
    }
</style>