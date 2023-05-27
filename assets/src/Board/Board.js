import React from "react";
import {copyArray} from "../Helpers/copyArray";
import {SudokuNavigator} from "../Helpers/SudokuNavigator";
import {Timer} from "./Timer";
import {Grid} from "./Grid";
import {Keypad} from "./Keypad";
import {Actions} from "./Actions/Actions";
import {DifficultyBoard} from "./DifficultyBoard/DifficultyBoard";
import {MessageButton} from "./MessageButton";

export class Board extends React.Component {
    constructor(props) {
        super(props);

        const initialBoard = copyArray(props.gameSet.initialBoard);
        const board = copyArray(props.gameSet.initialBoard);
        const boardErrors = board.map(row => row.map(() => false));
        const notes = board.map(row => row.map(() => new Array(9).fill(null)));
        const notesErrors = notes.map(row => row.map((notes) => notes.map(() => false)));

        const emptyCellsCount = board.reduce(
            (total, row) => total - row.reduce((subtotal, value) => subtotal + (value ? 1 : 0), 0), 81
        );

        const history = [{
            board: board,
            boardErrors: boardErrors,
            notes: notes,
            notesErrors: notesErrors,
            emptyCellsCount: emptyCellsCount,
            activeCell: {
                row: 0,
                column: 0,
            },
        }];

        this.state = {
            activeCell: {
                row: 0,
                column: 0,
            },
            initialBoard: initialBoard,
            board: board,
            boardErrors: boardErrors,
            notes: notes,
            notesErrors: notesErrors,
            emptyCellsCount: emptyCellsCount,
            notesMode: false,
            win: false,
            difficultyLevel: this.props.difficultyLevel,
            history: history,
            timer: {
                duration: 0,
                on: true,
            },
        }
    }

    componentDidMount() {

        setInterval(() => {

            if (!this.state.timer.on || this.state.win) {
                return;
            }

            this.setState(state => {
                return ({
                    timer: {
                        duration: state.timer.duration + 1,
                        on: state.timer.on,
                    },
                });
            });

        }, 1000);
    }

    toggleTimer() {
        if (this.state.win) {
            return;
        }

        this.setState(state => {
            const timer = {
                duration: state.timer.duration,
                on: !state.timer.on,
            };
            return ({ timer });
        });
    }

    addHistoryEntry() {

        this.setState(state => {

            const history = copyArray(state.history);
            history.push({
                board: copyArray(state.board),
                boardErrors: copyArray(state.boardErrors),
                notes: copyArray(state.notes),
                notesErrors: copyArray(state.notesErrors),
                emptyCellsCount: state.emptyCellsCount,
                activeCell: state.activeCell,
            });

            return ({ history });
        });
    }

    hasInitialValue(row = this.state.activeCell.row, column = this.state.activeCell.column) {
        return !!this.state.initialBoard[row][column];
    }

    hasAnyValue(row = this.state.activeCell.row, column = this.state.activeCell.column) {
        return !!this.state.board[row][column];
    }

    hasAnyNotes(row = this.state.activeCell.row, column = this.state.activeCell.column) {
        return this.state.notes[row][column].some((element) => element !== null);
    }

    handleKeyDown(event) {

        if (!this.state.timer.on) {
            return;
        }

        const key = event.key;
        const keyCode = event.keyCode;

        // 37 to 40 are Arrows keys
        if (keyCode >= 37 && keyCode <= 40) {
            this.move(key);
            return;
        }

        // 32 is Space key
        if (keyCode === 32) {
            this.toggleNotesMode();
            return;
        }

        if (key >= 1 && key <= 9) {
            this.setCellContent(key);
            return;
        }

        if (key === "Backspace") {
            this.clearCellContent();
            return;
        }
    }

    move(key) {

        let move = {
            row: 0,
            column: 0,
        }

        switch(key) {
            case 'ArrowLeft'  : move.column -= 1; break;
            case 'ArrowUp'    : move.row -= 1;    break;
            case 'ArrowRight' : move.column += 1; break;
            case 'ArrowDown'  : move.row += 1;    break;
            default: break;
        }

        const newRow = this.state.activeCell.row + move.row;
        const newColumn = this.state.activeCell.column + move.column;

        if (newRow < 0 || newRow > 8 || newColumn < 0 || newColumn > 8) {
            return;
        }

        this.activateCell(newRow, newColumn);
    }

    activateCell(row, column) {

        this.setState({
            activeCell: {
                row: row,
                column: column,
            }
        });
    }

    toggleDifficultyLevel(name, value) {
        let {[name]: _, ...rest} = this.state.difficultyLevel;
        this.setState({
            difficultyLevel: {[name]: value, ...rest},
        });
    }

    toggleAllDifficultyLevels() {

        const difficultyLevel = this.state.difficultyLevel;
        const level = (Object.values(difficultyLevel).some(level => level === false));

        Object.keys(difficultyLevel).forEach(function(key) {
            difficultyLevel[key] = level;
        });

        this.setState({
            difficultyLevel: difficultyLevel
        });
    }

    setCellContent(key) {

        if (this.hasInitialValue() || this.state.win) {
            return;
        }

        if (this.state.notesMode === false) {
            this.setCellValue(key);
        } else {
            this.toggleCellNotes(key);
        }
    }

    setCellValue(value) {

        value = parseInt(value);
        const row = this.state.activeCell.row;
        const column = this.state.activeCell.column;
        const previousValue = this.state.board[row][column];

        if (previousValue === value) {
            return;
        }

        let gameFinished = (
            (previousValue === null && this.changeEmptyCellsCount(-1) === 0)
            || this.state.emptyCellsCount === 0
        );

        let board = copyArray(this.state.board);
        board[row][column] = value;

        this.setState({
            board: board,
        });

        this.clearCellNotes();

        if (this.state.difficultyLevel.quickNotesRemoval) {
            this.clearVisibleNotes(value);
        }

        this.validateCell(value, this.setBoardError);

        if (gameFinished) {
            this.validateWin(board);
        }

        this.addHistoryEntry();
    }

    toggleCellNotes(value, row = this.state.activeCell.row, column = this.state.activeCell.column) {

        if (this.hasAnyValue(row, column)) {
            return;
        }

        value = parseInt(value);
        const key = value - 1;

        this.setState(state => {

            let notes = copyArray(state.notes);
            notes[row][column][key] = !!notes[row][column][key] ? null : value;

            return ({ notes });
        });

        this.validateCell(value, this.setNotesError);
        this.addHistoryEntry();
    }

    validateCell(value, setErrorCallback, row = this.state.activeCell.row, column = this.state.activeCell.column) {
        const notesKey = value - 1;
        setErrorCallback(
            !this.isValidValue(row, column, value),
            notesKey,
            row,
            column
        );
    }

    isValidValue(row, column, value) {
        const visibleCells = SudokuNavigator.getVisibleCellsCoordinates(row, column);
        return !visibleCells.some((element) => value === this.state.board[element[0]][element[1]]);
    }

    setBoardError = (isError, key = null, row = this.state.activeCell.row, column = this.state.activeCell.column) => {

        if (this.state.boardErrors[row][column] === isError) {
            return;
        }

        this.setState(state =>{

            let boardErrors = copyArray(state.boardErrors);
            boardErrors[row][column] = isError;

            return ({ boardErrors });
        });
    }

    setNotesError = (isError, key, row = this.state.activeCell.row, column = this.state.activeCell.column) => {

        if (this.state.notesErrors[row][column][key] === isError) {
            return;
        }

        this.setState(state => {

            let notesErrors = state.notesErrors;
            notesErrors[row][column][key] = isError;

            return ({ notesErrors });
        });
    }

    clearCellContent() {

        if (this.hasInitialValue() || this.state.win || (!this.hasAnyValue() && !this.hasAnyNotes())) {
            return;
        }

        this.clearCellValue();
        this.clearCellNotes();
        this.addHistoryEntry();
    }

    clearCellValue(row = this.state.activeCell.row, column = this.state.activeCell.column) {

        const previousValue = this.state.board[row][column];

        if (!previousValue) {
            return;
        }

        this.setState(state => {

            let board = state.board;
            board[row][column] = null;

            return ({ board });
        });

        this.setBoardError(false);
        this.changeEmptyCellsCount(1);
    }

    clearCellNotes(row = this.state.activeCell.row, column = this.state.activeCell.column) {

        if (!this.hasAnyNotes(row, column)) {
            return;
        }

        this.setState(state => {

            let notes = copyArray(state.notes);
            notes[row][column] = new Array(9).fill(null);

            let notesErrors = copyArray(state.notesErrors);
            notesErrors[row][column] = new Array(9).fill(false);

            return ({
                notes: notes,
                notesErrors: notesErrors,
            });
        });
    }

    toggleNotesMode() {
        this.setState(state => ({
            notesMode: !state.notesMode,
        }));
    }

    setQuickNotes() {

        this.setState(state => {

            let notes = state.board.map(row => row.map(() => new Array(9).fill(null)));
            let notesErrors = notes.map(row => row.map((notes) => notes.map(() => false)));

            for (let row = 0; row < 9; row++) {
                for (let column = 0; column < 9; column++) {
                    if (state.board[row][column] === null) {
                        for (let value = 1; value <= 9; value++) {
                            if (this.isValidValue(row, column, value)) {
                                notes[row][column][value - 1] = value;
                            }
                        }
                    }
                }
            }

            return ({
                notes: notes,
                notesErrors: notesErrors,
            });
        });

        this.addHistoryEntry();
    }

    undo() {

        if (this.state.history.length === 1 || this.state.win) {
            return;
        }

        this.setState(state => {

            const history = copyArray(state.history);
            history.pop();
            const restored = history.slice(-1)[0];

            return ({
                board: restored.board,
                boardErrors: restored.boardErrors,
                notes: restored.notes,
                notesErrors: restored.notesErrors,
                emptyCellsCount: restored.emptyCellsCount,
                activeCell: restored.activeCell,
                history: history,
            });
        });
    }

    restart() {

        if (this.state.history.length === 1 || this.state.win) {
            return;
        }

        this.setState(state => {

            const initialState = state.history[0];

            return ({
                board: copyArray(initialState.board),
                boardErrors: copyArray(initialState.boardErrors),
                notes: copyArray(initialState.notes),
                notesErrors: copyArray(initialState.notesErrors),
                emptyCellsCount: initialState.emptyCellsCount,
                activeCell: initialState.activeCell,
                history: [initialState],
                timer: {
                    duration: 0,
                    on: true,
                },
            });
        });
    }

    clearVisibleNotes(value) {

        const visibleCells = SudokuNavigator.getVisibleCellsCoordinates(this.state.activeCell.row, this.state.activeCell.column);
        const notesKey = value - 1;

        this.setState(state => {

            const notes = copyArray(state.notes);
            const notesErrors = copyArray(state.notesErrors);

            visibleCells.forEach((element) => {
                notes[element[0]][element[1]][notesKey] = null;
                notesErrors[element[0]][element[1]][notesKey] = false;
            });

            return ({
                notes: notes,
                notesErrors: notesErrors,
            });
        });
    }

    changeEmptyCellsCount(change) {

        const emptyCellsCount = this.state.emptyCellsCount + change;

        this.setState({
            emptyCellsCount: emptyCellsCount,
        });

        return emptyCellsCount;
    }

    validateWin(board) {

        function testCombination(value, index) { return value === winningCombination[index]; }
        function emptyNineArray() { return [[], [], [], [], [], [], [], [], []]; }

        const winningCombination = [1, 2, 3, 4, 5, 6, 7, 8, 9];

        const boxes = emptyNineArray();
        const rows = emptyNineArray();
        const columns = emptyNineArray();

        for (let row = 0; row < 9; row++) {
            for (let column = 0; column < 9; column++) {

                const boxKey = (Math.floor(row / 3) * 3) + Math.floor(column / 3);
                const value = board[row][column];

                boxes[boxKey].push(value);
                rows[row].push(value);
                columns[column].push(value);
            }
        }

        for (let i = 0; i < 9; i++) {
            if (
                !boxes[i].sort().every(testCombination)
                || !rows[i].sort().every(testCombination)
                || !columns[i].sort().every(testCombination)
            ) {
                return;
            }
        }

        this.setState(state => ({
            boardErrors: state.board.map(row => row.map(() => false)),
            win: true,
        }));
    }

    render() {

        console.log(this.state);

        return (
            <div className="flex justify-center sm:justify-start">
                <div id="Board"
                     className="m-0 p-2 focus:outline-none "
                     tabIndex={-1}
                     onKeyDown={event => {this.handleKeyDown(event)}}
                >

                    <Timer timer={this.state.timer} toggleTimer={() => this.toggleTimer()}/>

                    {this.state.timer.on && <div>

                        <Grid
                            activeCell={this.state.activeCell}
                            activateCell={(row, column) => this.activateCell(row, column)}
                            board={this.state.board}
                            boardErrors={this.state.boardErrors}
                            notes={this.state.notes}
                            notesErrors={this.state.notesErrors}
                            highlightedDigit={this.state.board[this.state.activeCell.row][this.state.activeCell.column]}
                            difficultyLevel={this.state.difficultyLevel}
                            hasInitialValue={(row, column) => this.hasInitialValue(row, column)}
                        />


                        {!this.state.win && <div>

                            <Keypad
                                setCellContent={(digit) => this.setCellContent(digit)}
                                valuesCount={
                                    this.state.board.reduce(
                                        (acc, row) => row.reduce(
                                            (acc, value) => acc.set(value, (acc.get(value) || 0) + 1), acc),
                                        new Map()
                                    )
                                }
                                difficultyLevel={this.state.difficultyLevel}
                            />

                            <Actions
                                actionTrash={() => this.clearCellContent()}
                                actionToggleNotesMode={() => this.toggleNotesMode()}
                                notesMode={this.state.notesMode}
                                actionQuickNotes={() => this.setQuickNotes()}
                                actionUndo={() => this.undo()}
                                actionRestart={() => this.restart()}
                                difficultyLevel={this.state.difficultyLevel}
                            />

                            <DifficultyBoard
                                difficultyLevel={this.state.difficultyLevel}
                                toggleDifficultyLevel={(name, level) => this.toggleDifficultyLevel(name, level)}
                                toggleAllDifficultyLevels={() => this.toggleAllDifficultyLevels()}
                            />

                        </div>}

                    </div>}

                    {this.state.win && <MessageButton message="Congratulations, Sudoku solved!" />}

                </div>
            </div>
        );
    }
}