import React from 'react';
import {Board} from "../Board/Board";
import {difficultyLevel} from "./difficultyLevel";
import {GameRepository} from "./GameRepository";

export class GameNew extends React.Component
{
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
        GameRepository.load(null, false, this.handleLoad);
    }

    render() {

        if (!this.state.isLoaded) {
            return <div>Loading...</div>;
        } else if (this.state.isError) {
            return <div>Error loading Sudoku</div>;
        } else {
            return <Board difficultyLevel={difficultyLevel} gameSet={this.state.gameSet} />;
        }
    }
}
