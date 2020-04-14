import React from 'react';
import GridPiece from './GridPiece';
import piecesConfig from '../piecesConfig.json';

export default
class ActiveItem extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            config: piecesConfig,
            posX:this.props.posX,
            posY:this.props.posY,
            rotation:this.props.rotation,
            itemConfig:[]
        };
        window.addEventListener("keydown", this.keyDown);
    }
    componentDidMount() {
        this.interval = setInterval(() => {
            this.setState({posY:this.state.posY + 1});
            this.updatePiece();
            this.checkForCollisions();
        }, 300);
    }
    componentWillUnmount() {
        window.removeEventListener("keydown", this.keyDown);
        clearInterval(this.interval);
    }
    moveDown = () => {
        this.setState({posY:this.state.posY + 1});
    };
    keyDown = (e) => {
        //Left
        if(e.keyCode === 37) {
            if(this.allowedMoveLeftRight(-1))this.setState({posX:this.state.posX - 1});
        }
        //Right
        if(e.keyCode === 39) {
            if(this.allowedMoveLeftRight(1))this.setState({posX:this.state.posX + 1});
        }
        //Up - Rotate
        if(e.keyCode === 38) {
            this.setState({rotation:(this.state.rotation + 1)%4});
        }
        //Down
        if(e.keyCode === 40) {
            this.setState({posY:this.state.posY + 1});
        }
        //Space bar
        if(e.keyCode === 32) {

        }
        this.updatePiece();
        this.checkForCollisions();
    };

    updatePiece = () => {
        let _x = 0;
        let _y = 0;
        let block = this.state.config[this.props.config][this.state.rotation];
        let itemConfig = [];
        for(let y = 0; y < block.length; y++){
            for(let x = 0; x < block[y].length; x++){
                if(block[y][x] > 0){
                    _x = x + this.state.posX;
                    _y = y + this.state.posY;
                    itemConfig.push({x:_x, y:_y});
                }
            }
        }
        this.setState({itemConfig:itemConfig});
    };

    allowedMoveLeftRight = (step) =>{
        let _x = 0;
        for(let i = 0; i<this.state.itemConfig.length; i++) {
            _x = this.state.itemConfig[i].x + step;
            if(_x < 0)return false;
            if(_x > this.props.deckData[0].length - 1)return false;
        }
        return true;
    };

    checkForCollisions = () => {
        let itemConfig = this.state.itemConfig;
        let collisionFound = false;
        let _x = 0;
        let _y = 0;
        for(let i = 0; i<itemConfig.length; i++){
            _x = itemConfig[i].x;
            _y = itemConfig[i].y + 1;

            if(_y > 0){
                if(typeof this.props.deckData[_y] === 'undefined'){
                    collisionFound = true;
                    break;
                } else {
                    if(this.props.deckData[_y][_x] !== 'undefined' && this.props.deckData[_y][_x] > 0){
                        collisionFound = true;
                        break;
                    }
                }
            }
        }
        if(collisionFound) {
            this.props.collisionHandler(itemConfig, this.props.config);
        }
    };

    render() {
        const pieces = this.state.itemConfig.map((d, index) => <GridPiece key={index} color={(this.props.config+1)} size={this.props.size} posX={d.x} posY={d.y}/>);
        return <div>{pieces}</div>;
    }
}