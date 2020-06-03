<template>
    <div>
        <div class="frame" :style="frameStyle">
        <div class="score" v-if="!gameOver">{{linesCleared}}</div>
        <Grid :deck="deck" :deckSize="deckSize" :pieceSize="pieceSize" :lineToClear="lineToClear"/>
        <ActiveItem v-if="activeItem.active"
                :pieceSize="pieceSize"
                :deck="deck"
                :posX="activeItem.posX"
                :posY="activeItem.posY"
                :config="activeItem.config"
                :rotation="activeItem.rotation"
                :collisionHandler="onCollisionCallback"
                :finishedHandler="onGameFinishedCallback"
        />
        <div class="game-over" v-if="gameOver">Game over <br>{{linesCleared}} lines cleared</div>
        </div>
        <div class="preview-item-frame">
            <PreviewItem :pieceSize="20" :config="nextItem.config" :rotation="nextItem.rotation"></PreviewItem>
        </div>
    </div>
</template>

<script>

import Grid from './components/Grid'
import ActiveItem from './components/ActiveItem'
import PreviewItem from './components/PreviewItem'
import level1Data from './levels/level1.json';

  export default {
    name: "app",
    data: function(){
      return {
          deck: [],
          deckSize: {
              gridX: 0,
              gridY: 0,
              sizeX: 0,
              sizeY: 0
          },
          pieceSize: 0,
          activeItem:{
              active:false,
              rotation:0,
              posX:0,
              posY:0,
              config:2
          },
          nextItem:{
              config:2,
              rotation:1
          },
          gameOver:false,
          linesCleared:0,
          lineToClear:null
      }
    },
    components: {
        Grid, ActiveItem, PreviewItem
    },
    computed:{
      frameStyle:function(){
          return {
              width:this.deckSize.sizeX+'px',
              height:this.deckSize.sizeY+'px'
          };
      }
    },
    methods:{
        createDeckFromData: function(data, pieceSize){

            this.deck = [];

            this.deckSize.gridX = data[0].length;
            this.deckSize.gridY = data.length;
            this.pieceSize = pieceSize;
            this.deckSize.sizeX = this.deckSize.gridX * pieceSize;
            this.deckSize.sizeY = this.deckSize.gridY * pieceSize;

            for(let y=0; y<this.deckSize.gridY; y++){
                let line = [];
                for(let x=0; x<this.deckSize.gridX; x++){
                    line.push(data[y][x]);
                }
                this.deck.push(line);
            }
        },
        createDeck: function(gridX, gridY, pieceSize){
            this.deckSize.gridX = gridX;
            this.deckSize.gridY = gridY;
            this.pieceSize = pieceSize;
            this.deckSize.sizeX = gridX * pieceSize;
            this.deckSize.sizeY = gridY * pieceSize;

            let deck = [];
            for(let y=0; y<gridY; y++){
                let line = [];
                for(let x=0; x<gridX; x++){
                    line.push(0);
                }
                deck.push(line);
            }
            this.deck = deck;
        },
        onCollisionCallback:function(itemConfig, color){
            let _x = 0;
            let _y = 0;
            //Merge pieces into deck
            for(let i = 0; i<itemConfig.length; i++) {
                _x = itemConfig[i].x;
                _y = itemConfig[i].y;
                if(typeof this.deck[_y] !== 'undefined'
                    && typeof this.deck[_y][_x] !== 'undefined'){

                    const newRow = this.deck[_y].slice(0);
                    newRow[_x] = color + 1;
                    this.$set(this.deck, _y, newRow);
                }
            }
            //Check for completed lines to clear
            this.clearLinesAndContinue();
        },
        clearLinesAndContinue:function(){
            this.activeItem.active = false;
            //Clear selected full line
            if(this.lineToClear !== null) {
                this.deck.splice(this.lineToClear, 1);
                this.linesCleared++;

                this.lineToClear = null;

                //Add missing empty lines in top of deck
                while(this.deck.length < this.deckSize.gridY){
                    let line = [];
                    for(let x=0; x<this.deckSize.gridX; x++){
                        line.push(0);
                    }
                    this.deck.unshift(line);
                }
                this.$forceUpdate();
            }
            this.$nextTick(function(){
                //Check if there is more lines to clear
                for (let y = 0; y < this.deck.length; y++) {
                    let clear = true;
                    for(let x=0; x < this.deck[y].length; x++){
                        if(this.deck[y][x] === 0){
                            clear = false;
                            break;
                        }
                    }
                    if(clear) {
                        this.lineToClear = y;
                        break;
                    }
                }
                if(this.lineToClear !== null){
                    //Set timer for next line to clear
                    let parent = this;
                    setTimeout(function(){
                        parent.clearLinesAndContinue();
                    }, 1000);
                }else{  //No more new lines to clear, generate new piece
                    this.generateNextItem();
                }
            });
        },
        onGameFinishedCallback:function(){
            this.activeItem.active = false;
            this.gameOver = true;
            clearInterval(this.interval);
        },
        generateNewItem: function(){
            const maxColors = 5;
            this.activeItem.config = this.nextItem.config;
            this.activeItem.posX = Math.floor(this.deckSize.gridX / 2) - 2;
            this.activeItem.posY = 0;
            this.activeItem.rotation = this.nextItem.rotation;

            this.nextItem.config = Math.floor(Math.random() * 7);
            this.nextItem.rotation = Math.floor(Math.random() * 2);
        },
        keyDown: function(e){
            //Space bar - generate new item
            // if(e.keyCode === 32) {
            //     this.generateNewItem();
            //     this.activeItem.active = true;
            // }
        },
        generateNextItem: function(){
            let parent = this;
            this.interval = setTimeout(function(){
                parent.generateNewItem();
                parent.activeItem.active = true;
            }, 200);
        }
    },
    mounted:function() {
        window.addEventListener("keydown", this.keyDown);
//        this.createDeck(30, 20, 25);
        this.createDeckFromData(level1Data, 30);

        this.generateNewItem();
        this.generateNextItem();
    }
  }

</script>

<style scoped>
    @import url('https://fonts.googleapis.com/css?family=Chau+Philomene+One');
    .frame{
        position:absolute;
        top:10px;
        left:100px;
        border:solid 10px gray;
        background: linear-gradient(to bottom, rgba(147,206,222,1) 0%, rgba(117,189,209,1) 41%, rgba(73,165,191,1) 100%);
    }
    .frame:before{
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity:0.7;
        background:
                linear-gradient(-90deg, rgba(0, 0, 255, 0.05) 1px, transparent 1px),
                linear-gradient(rgba(0,0,0,.05) 1px, transparent 1px),
                linear-gradient(-90deg, rgba(0, 0, 0, .04) 1px, transparent 1px),
                linear-gradient(rgba(0,0,0,.04) 1px, transparent 1px),
                linear-gradient(transparent 3px, #f2f2f2 3px, #f2f2f2 78px, transparent 78px),
                linear-gradient(-90deg, #aaa 1px, transparent 1px),
                linear-gradient(-90deg, transparent 3px, #f2f2f2 3px, #f2f2f2 78px, transparent 78px),
                linear-gradient(#171717 1px, transparent 1px),
                #f2f2f2;
        background-size:
                6px 6px,
                6px 6px,
                30px 30px,
                30px 30px,
                30px 30px,
                30px 30px,
                30px 30px,
                30px 30px;
        mix-blend-mode: multiply;
    }
    .game-over{
        font-family: "Chau Philomene One", sans-serif;
        font-weight: bold;
        font-size: 40px;
        letter-spacing: -2px;
        word-spacing: 6px;
        color: white;
        text-shadow: rgba(0, 0, 0, 0.8) 2px 2px 8px;
        position:relative;
        width:100%;
        top: 50%;
        text-align: center;
    }
    .score{
        margin-left: 10px;
        margin-top: 10px;
        font-family: "Chau Philomene One", sans-serif;
        font-weight: bold;
        font-size: 50px;
        letter-spacing: -2px;
        word-spacing: 6px;
        color: white;
        text-shadow: rgba(0, 0, 0, 0.8) 2px 2px 8px;
        position:relative;
        text-align: center;
    }
    .preview-item-frame{
        position:absolute;
        width:80px;
        height:80px;
        left:10px;
        top:10px;
        border:solid 10px gray;
        background-color: gray;
    }
</style>

<style>
    body{
        background: linear-gradient(to bottom, #606c88 0%,#3f4c6b 100%);  
        background-repeat: no-repeat;
        background-size: 100% 1400px;   
    }
</style>