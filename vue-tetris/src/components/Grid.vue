<template>
    <div>
        <GridPiece v-for="(piece, index) in staticPieces"
                   :key="index"
                   :posX="piece.posX"
                   :posY="piece.posY"
                   :size="pieceSize"
                   :color="piece.color"
        />
    </div>
</template>

<script>

import GridPiece from './GridPiece'

    export default {
        name: "Grid",
        props: ['deck', 'deckSize', 'pieceSize'],
        components: {
            GridPiece
        },
        computed:{
            staticPieces:function(){
                let staticPieces = [];
                for(let y=0; y<this.deckSize.gridY; y++){
                    for(let x=0; x<this.deckSize.gridX; x++){
                        if(this.deck[y][x] > 0){
                            staticPieces.push(
                                {
                                    color:this.deck[y][x],
                                    posX:x,
                                    posY:y
                                }
                            );
                        }
                    }
                }
                return staticPieces;
            }
        }
    }
</script>
