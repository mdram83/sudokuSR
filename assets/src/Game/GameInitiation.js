import React from 'react';
import {MessageButton} from "../Board/MessageButton";
import {GameNew} from "./GameNew";
import {GameResume} from "./GameResume";
import {Board} from "../Board/Board";

export class GameInitiation extends React.Component
{
    constructor(props) {
        super(props)

        this.state = {
            gameStarted: false,
            newGame: true,
            gameSet: null,
        }
    }

    newGame() {
        this.setState({
            gameStarted: true,
            newGame: true,
        });
    }

    resumeGame(gameSet, parent) {
        parent.setState({
            gameStarted: true,
            newGame: false,
            gameSet: gameSet,
        });
    }

    render() {
        return (
            <div>

                {!this.state.gameStarted &&
                    <div className="flex justify-center sm:justify-start m-0 p-2 focus:outline-none grid grid-cols-1 gap-0 w-72">
                        <MessageButton action={() => this.newGame()} message="New Game" />
                        <GameResume callback={this.resumeGame} parent={this} />
                    </div>
                }

                {this.state.gameStarted && this.state.newGame &&
                    <GameNew />
                }

                {this.state.gameStarted && !this.state.newGame &&
                    <Board gameSet={this.state.gameSet} />
                }

            </div>
        );
    }
}