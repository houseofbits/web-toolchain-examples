import React from 'react';
import ReactDOM from 'react-dom';
import Grid from './components/Grid';
import ActiveItem from './components/ActiveItem';
import './style.css';

class ProductList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            deck: this.createDeck(this.props.width, this.props.height),
            deckSize: {
                gridX: this.props.width,
                gridY: this.props.height,
                sizeX: (this.props.width * this.props.size),
                sizeY: (this.props.height * this.props.size)
            },
            pieceSize: this.props.size,
            activeItem:{
                active:false,
                rotation:0,
                posX:0,
                posY:0,
                config:6
            }
        };
        window.addEventListener("keydown", this.keyDown);
    }
    componentDidMount() {
        this.generateNextItem();
    }
    componentWillUnmount() {
        clearInterval(this.interval);
    }
    generateNextItem = () => {
        this.interval = setTimeout(() => {
            this.generateNewItem();
            this.setState(state => (state.activeItem.active = true));
        }, 500);
    };
    keyDown = (e) => {
        //Space bar - generate new item
        if(e.keyCode === 32) {
            this.generateNewItem();
            this.setState(state => (state.activeItem.active = true));
        }
    };
    /**
     * Merge active piece into deck, remove filled lines and generate new piece;
     * @param itemConfig
     * @param color
     */
    onCollisionCallback = (itemConfig, color) => {
        let _x = 0;
        let _y = 0;
        let deck = this.state.deck;
        for(let i = 0; i<itemConfig.length; i++) {
            _x = itemConfig[i].x;
            _y = itemConfig[i].y;
            if(typeof deck[_y] !== 'undefined'
                && typeof deck[_y][_x] !== 'undefined'){
                deck[_y][_x] = color + 1;
            }
        }
        for (let y = 0; y < deck.length; y++) {
            let clear = true;
            for(let x=0; x < deck[y].length; x++){
                if(deck[y][x] === 0){
                    clear = false;
                    break;
                }
            }
            if(clear){
                deck.splice(y, 1);
                y = 0;
            }
        }
        while(deck.length < this.state.deckSize.gridY){
            let line = [];
            for(let x=0; x<this.state.deckSize.gridX; x++){
                line.push(0);
            }
            deck.unshift(line);
        }

        this.setState({deck:deck});
        this.setState(state => (state.activeItem.active = false));
        this.generateNextItem();
    };
    /**
     * Generate data for new piece
     */
    generateNewItem = () => {
        const maxColors = 5;
        let activeItem = this.state.activeItem;
        activeItem.config = Math.floor(Math.random() * 7);
        activeItem.posX = 0;
        activeItem.posY = 0;
        activeItem.rotation = Math.floor(Math.random() * 2);
        this.setState({activeItem:activeItem});
    };
    /**
     *
     * @param gridX
     * @param gridY
     * @returns {Array}
     */
    createDeck = (gridX, gridY) => {
        let deck = [];
        for(let y=0; y<gridY; y++){
            let line = [];
            for(let x=0; x<gridX; x++){
                line.push(0);
            }
            deck.push(line);
        }
        return deck;
    };
    render() {
        const frameStyle = {
            width:this.state.deckSize.sizeX+'px',
            height:this.state.deckSize.sizeY+'px'
        };
        let item = '';
        if(this.state.activeItem.active) {
            item = <ActiveItem
                size={this.state.pieceSize}
                posX={this.state.activeItem.posX}
                posY={this.state.activeItem.posY}
                config={this.state.activeItem.config}
                rotation={this.state.activeItem.rotation}
                collisionHandler={this.onCollisionCallback}
                deckData={this.state.deck}/>;
        }
        return (
            <div>
                <div className="frame" style={frameStyle}>
                    <Grid
                        pieceSize={this.state.pieceSize}
                        deckSize={this.state.deckSize}
                        deck={this.state.deck}
                    />
                    {item}
                </div>
            </div>
        );
    }
}

ReactDOM.render(<ProductList width="10" height="20" size="30"/>, document.getElementById('root'));
