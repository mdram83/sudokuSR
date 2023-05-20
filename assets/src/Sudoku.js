import React from 'react';
import {Board} from "./Board/Board";
import {gameSet} from "./Game/gameSet";
import {difficultyLevel} from "./Game/difficultyLevel";

function Sudoku() {
    return (
        <div>
            <Board
                difficultyLevel={difficultyLevel}
                gameSet={gameSet}
            />
        </div>
    );
}

export default Sudoku;
