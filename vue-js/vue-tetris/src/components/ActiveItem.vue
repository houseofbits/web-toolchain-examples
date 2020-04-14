<template>
    <div>
        <GridPiece v-for="(item, index) in itemConfig"
               :key="index"
               :posX="item.x"
               :posY="item.y"
               :size="pieceSize"
               :color="config+1"
        />
    </div>
</template>

<script>

    import GridPiece from './GridPiece';
    import piecesConfig from '../piecesConfig.json';

    export default {
        name: "ActiveItem",
        components: {GridPiece},
        props: ['deck', 'pieceSize', 'posX', 'posY', 'config', 'rotation', 'collisionHandler'],
        data: function(){
            return {
                configuration: piecesConfig,
                positionX:this.posX,
                positionY:this.posY,
                rotationIndex:this.rotation,
                itemConfig:[],
                interval:null
            }
        },
        methods:{
            keyDown:function (e) {
                //Left
                if(e.keyCode === 37) {
                    if(this.allowedMoveLeftRight(-1)) this.positionX--;
                }
                //Right
                if(e.keyCode === 39) {
                    if(this.allowedMoveLeftRight(1))this.positionX++;
                }
                //Up - Rotate
                if(e.keyCode === 38) {
                    this.rotationIndex = (this.rotationIndex + 1)%4;
                }
                //Down
                if(e.keyCode === 40) {
                    this.positionY++;
                }
                //Space bar
                if(e.keyCode === 32) {

                }
                this.updatePiece();
                this.checkForCollisions();
            },
            updatePiece: function(){
                let _x = 0;
                let _y = 0;
                let block = this.configuration[this.config][this.rotationIndex];
                let itemConfig = [];
                for(let y = 0; y < block.length; y++){
                    for(let x = 0; x < block[y].length; x++){
                        if(block[y][x] > 0){
                            _x = x + this.positionX;
                            _y = y + this.positionY;
                            itemConfig.push({x:_x, y:_y});
                        }
                    }
                }
                this.itemConfig = itemConfig;
            },
            allowedMoveLeftRight:function(step){
                let _x = 0;
                for(let i = 0; i<this.itemConfig.length; i++) {
                    _x = this.itemConfig[i].x + step;
                    if(_x < 0)return false;
                    if(_x > this.deck[0].length - 1)return false;
                }
                return true;
            },
            checkForCollisions:function(){
                let itemConfig = this.itemConfig;
                let collisionFound = false;
                let _x = 0;
                let _y = 0;
                for(let i = 0; i<itemConfig.length; i++){
                    _x = itemConfig[i].x;
                    _y = itemConfig[i].y + 1;

                    if(_y > 0){
                        if(typeof this.deck[_y] === 'undefined'){
                            collisionFound = true;
                            break;
                        } else {
                            if(this.deck[_y][_x] !== 'undefined' && this.deck[_y][_x] > 0){
                                collisionFound = true;
                                break;
                            }
                        }
                    }
                }
                if(collisionFound) {
                    this.collisionHandler(itemConfig, this.config);
                }
            }
        },
        mounted:function(){
            this.updatePiece();
            window.addEventListener("keydown", this.keyDown);
            this.interval = setInterval(() => {
                this.positionY++;
                this.updatePiece();
                this.checkForCollisions();
            }, 300);
        },
        destroyed:function () {
            window.removeEventListener("keydown", this.keyDown);
            clearInterval(this.interval);
        }
    }
</script>

<style scoped>

</style>