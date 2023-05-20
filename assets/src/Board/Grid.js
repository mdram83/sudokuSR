import React from "react";
import {SudokuNavigator} from "../Helpers/SudokuNavigator";
import {Cell} from "./Cell";

export class Grid extends React.Component {

    getActiveCellId() {
        return SudokuNavigator.generateCellId(this.props.activeCell.row, this.props.activeCell.column);
    }

    handleCellClick(row, column) {
        if (SudokuNavigator.generateCellId(row, column) === this.getActiveCellId()) {
            return;
        }

        this.props.activateCell(row, column);
    }

    render() {

        const activeCellId = this.getActiveCellId();
        const elements = [];

        for (let row = 0; row < 9; row++) {

            for (let column = 0; column < 9; column++) {

                const key = SudokuNavigator.generateCellId(row, column);
                const active = (key === activeCellId);
                const visible = SudokuNavigator.isCellVisible(
                    this.props.activeCell.row,
                    this.props.activeCell.column,
                    row,
                    column
                );

                elements.push(
                    <Cell
                        key={key}
                        row={row}
                        column={column}
                        value={this.props.board[row][column]}
                        valueError={this.props.boardErrors[row][column]}
                        notes={this.props.notes[row][column]}
                        notesErrors={this.props.notesErrors[row][column]}
                        active={active}
                        visible={visible}
                        highlightedDigit={this.props.highlightedDigit}
                        onClick={() => this.handleCellClick(row, column)}
                        difficultyLevel={this.props.difficultyLevel}
                        hasInitialValue={this.props.hasInitialValue(row, column)}
                    />
                );
            }
        }

        return (
            <div className="border-0 border-gray-400 grid grid-cols-9 gap-0 w-72 h-72">
                {elements}
            </div>
        );
    }
}