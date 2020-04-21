<template>
  <div class="frame" :style="frameStyle">
    <div class="score" v-if="!gameOver">{{linesCleared}}</div>
    <Grid :deck="deck" :deckSize="deckSize" :pieceSize="pieceSize"/>
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
</template>

<script>

import Grid from './components/Grid'
import ActiveItem from './components/ActiveItem'

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
          gameOver:false,
          linesCleared:0
      }
    },
    components: {
        Grid, ActiveItem
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
            for (let y = 0; y < this.deck.length; y++) {
                let clear = true;
                for(let x=0; x < this.deck[y].length; x++){
                    if(this.deck[y][x] === 0){
                        clear = false;
                        break;
                    }
                }
                if(clear){
                    this.deck.splice(y, 1);
                    this.linesCleared++;
                    y = 0;
                }
            }
            while(this.deck.length < this.deckSize.gridY){
                let line = [];
                for(let x=0; x<this.deckSize.gridX; x++){
                    line.push(0);
                }
                this.deck.unshift(line);
            }

            this.activeItem.active = false;
            this.generateNextItem();
        },
        onGameFinishedCallback:function(){
            this.activeItem.active = false;
            this.gameOver = true;
            clearInterval(this.interval);
        },
        generateNewItem: function(){
            const maxColors = 5;
            this.activeItem.config = Math.floor(Math.random() * 7);
            this.activeItem.posX = 0;
            this.activeItem.posY = 0;
            this.activeItem.rotation = Math.floor(Math.random() * 2);
        },
        keyDown: function(e){
            //Space bar - generate new item
            if(e.keyCode === 32) {
                this.generateNewItem();
                this.activeItem.active = true;
            }
        },
        generateNextItem: function(){
            let parent = this;
            this.interval = setTimeout(function(){
                parent.generateNewItem();
                parent.activeItem.active = true;
            }, 500);
        }
    },
    mounted:function() {
        window.addEventListener("keydown", this.keyDown);
        this.createDeck(20, 30, 30);
        this.generateNextItem();
    }
  }

</script>

<style scoped>
    @import url('https://fonts.googleapis.com/css?family=Chau+Philomene+One');
    .frame{
        position:absolute;
        top:50px;
        left:50px;
        border:solid 10px gray;
        background-color: #9dbed0;
        background: linear-gradient(to bottom, rgba(147,206,222,1) 0%, rgba(117,189,209,1) 41%, rgba(73,165,191,1) 100%);
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
</style>