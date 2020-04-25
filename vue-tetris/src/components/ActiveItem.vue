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
    import wallKickConfig from '../wallKickConfig.json';

    export default {
        name: "ActiveItem",
        components: {GridPiece},
        props: ['deck', 'pieceSize', 'posX', 'posY', 'config', 'rotation', 'collisionHandler', 'finishedHandler'],
        data: function(){
            return {
                configuration: piecesConfig,
                collisionConfig: wallKickConfig,
                positionX:this.posX,
                positionY:this.posY,
                rotationIndex:this.rotation,
                itemConfig:[],
                interval:null,
                rotationMoveMapping:{
                    0:{1:0, 3:7},
                    1:{0:1, 2:2},
                    2:{1:3, 3:4},
                    3:{2:5, 0:6}
                },
                nextTickFinished: false,
                timeStep:300
            }
        },
        methods:{
            keyDown:function (e) {
                let newPosX = this.positionX;
                let newPosY = this.positionY;
                let newRotation = this.rotationIndex;

                console.log(e.keyCode);

                //Left
                if(e.keyCode === 37) {
                    newPosX--;
                }
                //Right
                if(e.keyCode === 39) {
                    newPosX++;
                }
                //Down
                if(e.keyCode === 40) {
                    newPosY++;
                }
                //88 - X
                if(e.keyCode === 88) {
                    newRotation = (newRotation + 1)%4;
                }
                //90 - Z
                if(e.keyCode === 90) {
                    newRotation = newRotation - 1;
                    if(newRotation < 0)newRotation = 3;
                }

                //Space bar
                // if(e.keyCode === 32) {
                //     this.collisionHandler(this.itemConfig, this.config);
                // }

                this.checkCollisionForward(newPosX, newPosY, this.rotationIndex, newRotation);
                this.updatePiece();
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
            getItemFromConfig:function(config){
                let _x = 0;
                let _y = 0;
                let itemConfig = [];
                for(let y = 0; y < config.length; y++){
                    for(let x = 0; x < config[y].length; x++){
                        if(config[y][x] > 0){
                            _x = x;
                            _y = y;
                            itemConfig.push({x:_x, y:_y});
                        }
                    }
                }
                return itemConfig;
            },
            checkCollisionForward:function(newPosX, newPosY, rotationIndex, newRotationIndex){
                if(!this.deck.length)return true;
                let updateCoordinates = true;
                //Get piece configuration at new rotation angle
                let forwardConfig = this.configuration[this.config][newRotationIndex];
                //Create array of [x,y] coordinates from piece configuration
                let itemConfig = this.getItemFromConfig(forwardConfig);
                //Test for piece > deck intersection
                if(this.intersect(itemConfig, newPosX, newPosY)) {
                    updateCoordinates = false;
                    //Check if piece is rotated
                    if (rotationIndex !== newRotationIndex) {
                        //Get wallKickConfig index from rotationIndex
                        if (typeof this.rotationMoveMapping[rotationIndex] !== 'undefined' &&
                            typeof this.rotationMoveMapping[rotationIndex][newRotationIndex] !== 'undefined') {

                            let wallKickIndex = this.rotationMoveMapping[rotationIndex][newRotationIndex];

                            let wallKickData = false;

                            //Get wallKick data for piece type
                            if(this.config === 0){ //I piece wall kick data
                                wallKickData = this.collisionConfig[1][wallKickIndex];
                            } else if (this.config === 3){ //O piece does not need wall kick
                            } else {    //j,l,z,s wall kick data
                                wallKickData = this.collisionConfig[0][wallKickIndex];
                            }
                            //Iterate over wall kick
                            for(let a=0; a<wallKickData.length; a++){
                                let inte = this.intersect(itemConfig, newPosX + wallKickData[a][0], newPosY + wallKickData[a][1]);
                                if(inte === false) {
                                    newPosX = newPosX + wallKickData[a][0];
                                    newPosY = newPosY + wallKickData[a][1];
                                    updateCoordinates = true;
                                    break;
                                }
                            }
                        }
                    }
                }
                //Update coordinates with resulting transforms
                if (updateCoordinates) {
                    this.positionX = newPosX;
                    this.positionY = newPosY;
                    this.rotationIndex = newRotationIndex;
                }
                return updateCoordinates;
            },
            /**
             * Intersect piece config with deck
             * @param pieceConfig
             * @param posX
             * @param posY
             */
            intersect:function(pieceConfig, posX, posY){
                let _x = 0;
                let _y = 0;
                for(let i = 0; i<pieceConfig.length; i++){
                    _x = pieceConfig[i].x + posX;
                    _y = pieceConfig[i].y + posY;
                    //Check grid
                    if(_y >= 0){
                        if(typeof this.deck[_y] === 'undefined'){
                            return true;
                        } else {
                            if(this.deck[_y][_x] !== 'undefined' && this.deck[_y][_x] > 0){
                                return true;
                            }
                        }
                    }
                    //Check deck boundary
                    if(_x < 0)return true;
                    if(_x > this.deck[0].length - 1)return true;
                    if(_y > this.deck.length - 1)return true;
                }
                return false;
            },
            stepGravity:function(){
                let newPosY = this.positionY + 1;
                let posUpdated = this.checkCollisionForward(this.positionX, newPosY, this.rotationIndex, this.rotationIndex);
                this.updatePiece();
                if (!posUpdated && this.nextTickFinished) {
                    this.collisionHandler(this.itemConfig, this.config);
                }
                if(this.nextTickFinished && posUpdated){
                    this.nextTickFinished = false;
                }else if(!this.nextTickFinished && !posUpdated){
                    this.nextTickFinished = true;
                }
            },
            checkGameOver:function () {
                let posUpdated = this.checkCollisionForward(this.posX, this.posY, this.rotation, this.rotation);
                if(!posUpdated){
                    this.finishedHandler();
                }
            }
        },
        mounted:function(){
            this.updatePiece();
            window.addEventListener("keydown", this.keyDown);
            this.interval = setInterval(() => {
                this.stepGravity();
            }, this.timeStep);
            this.checkGameOver();
        },
        destroyed:function () {
            window.removeEventListener("keydown", this.keyDown);
            clearInterval(this.interval);
        }
    }
</script>

<style scoped>

</style>