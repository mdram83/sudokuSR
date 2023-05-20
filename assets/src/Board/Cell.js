import React from "react";
import {SudokuNavigator} from "../Helpers/SudokuNavigator";
import {Value} from "./Value";
import {Notes} from "./Notes";

export const Cell = (props) => {

    const isFirstBoxRow = (props.row % 3 === 0);
    const isLastGridRow = (props.row === 8);
    const isFirstBoxColumn = (props.column % 3 === 0);
    const isLastGridColumn = (props.column === 8);

    return (
        <div id={SudokuNavigator.generateCellId(props.row, props.column)}
             className={
                 "border-gray-400 flex justify-center m-0 p-0 hover:bg-gray-300 hover:cursor-default focus:outline-none"
                 + (isFirstBoxRow ? " border-t-2" : " border-t")
                 + (isLastGridRow ? " border-b-2" : "")
                 + (isFirstBoxColumn ? " border-l-2" : " border-l")
                 + (isLastGridColumn ? " border-r-2" : "")
                 + (props.active ? " bg-gray-300" : "")
                 + ((props.visible && props.difficultyLevel.highlightGrid) ? " bg-gray-100" : "")
             }
             onClick={props.onClick}
             tabIndex={-1}
        >
            {
                props.value
                    ? <Value
                        value={props.value}
                        valueError={props.valueError}
                        hasInitialValue={props.hasInitialValue}
                        highlight={props.highlightedDigit === props.value}
                        highlightValue={props.difficultyLevel.highlightValue}
                        highlightErrors={props.difficultyLevel.highlightErrors}
                    />
                    : <Notes
                        notes={props.notes}
                        notesErrors={props.notesErrors}
                        highlightedDigit={props.highlightedDigit}
                        highlightNotes={props.difficultyLevel.highlightNotes}
                        highlightErrors={props.difficultyLevel.highlightErrors}
                    />
            }
        </div>
    );
}