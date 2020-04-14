import React from 'react';

export default
class GridPiece extends React.Component {
    render() {
        let pieceClass = 'piece color'+(this.props.color-1);
        let pieceStyle = {
            width:this.props.size + 'px',
            height:this.props.size + 'px',
            top:(this.props.posY * this.props.size)+ 'px',
            left:(this.props.posX * this.props.size) + 'px',
        };
        return <div className={pieceClass} style={pieceStyle} />;
    }
}
