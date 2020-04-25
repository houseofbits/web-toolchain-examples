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

    import piecesConfig from '../piecesConfig.json';
    import GridPiece from './GridPiece';

    export default {
        name: "PreviewItem",
        components: {GridPiece},
        props: ['config', 'rotation', 'pieceSize'],
        computed:{
            itemConfig:function(){
                let block = piecesConfig[this.config][this.rotation];
                let itemConfig = [];
                for(let y = 0; y < block.length; y++){
                    for(let x = 0; x < block[y].length; x++){
                        if(block[y][x] > 0){
                            itemConfig.push({x:x, y:y});
                        }
                    }
                }
                return itemConfig;
            }
        },
    }
</script>

<style scoped>

</style>