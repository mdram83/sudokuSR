import React from 'react';
import {Board} from "./Board/Board";
import {difficultyLevel} from "./Game/difficultyLevel";
import {GameRepository} from "./Game/GameRepository";

export class Sudoku extends React.Component
{
    #gameRepository = new GameRepository();

    constructor(props) {
        super(props);

        this.state = {
            isLoaded: false,
            isError: false,
            gameSet: null,
        };
    }

    handleLoad = ({isLoaded, isError, gameSet = null} = {}) => {
        this.setState({
            isLoaded: isLoaded,
            isError: isError,
            gameSet: gameSet,
        });
    }

    componentDidMount() {
        this.#gameRepository.load(null, null, this.handleLoad);
    }

    render() {

        if (!this.state.isLoaded) {
            return <div>Loading...</div>;
        } else if (this.state.isError) {
            return <div>Error loading Sudoku</div>;
        } else {
            return <div><Board difficultyLevel={difficultyLevel} gameSet={this.state.gameSet} /></div>;
        }
    }
}
