import React from 'react';
import GridPiece from './GridPiece';

export default
class Grid extends React.Component {
    render() {
        let pieceSize = this.props.pieceSize;
        let key = 0;
        let staticPieces = [];
        for(let y=0; y<this.props.deckSize.gridY; y++){
            for(let x=0; x<this.props.deckSize.gridX; x++){
                if(this.props.deck[y][x] > 0){
                    staticPieces.push( <GridPiece key={key} color={this.props.deck[y][x]} size={pieceSize} posX={x} posY={y}/> );
                    key++;
                }
            }
        }
        return <div>{staticPieces}</div>;
    }
}
