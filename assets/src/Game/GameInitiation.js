import React from 'react';
import {MessageButton} from "../Board/MessageButton";
import {Sudoku} from "../Sudoku";

export class GameInitiation extends React.Component
{
    constructor(props) {
        super(props)

        this.state = {
            gameStarted: false,
            previousGameAvailable: false,
            previousGameLoaded: false,
            previousGameError: false,
            previousGame: {},
            previousGameSelected: false,
            newGameSelected: false,
        }
    }

    newGame() {
        this.setState({
            gameStarted: true,
            newGameSelected: true,
        });
    }

    // TODO loading previous game, enable button if available, pass game to Sudoku or directly to Board

    render() {
        return (
            <div>
                {!this.state.gameStarted &&
                    <div className="flex justify-center sm:justify-start m-0 p-2 focus:outline-none grid grid-cols-1 gap-0 w-72">

                        <MessageButton
                            // action={() => this.continueGame()}
                            message="Continue..."
                        />

                        <MessageButton
                            action={() => this.newGame()}
                            message="New Game"
                        />

                    </div>
                }

                {this.state.gameStarted && <Sudoku />}
            </div>
        );
    }
}