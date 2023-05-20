import React from "react";
import {ActionTrash} from "./ActionTrash";
import {ActionToggleNotesMode} from "./ActionToggleNotesMode";
import {ActionQuickNotes} from "./ActionQuickNotes";
import {ActionUndo} from "./ActionUndo";
import {ActionRestart} from "./ActionRestart";

export const Actions = (props) => {
    return (
        <div className="grid grid-cols-9 gap-1 w-72 h-8 mt-8">

            <ActionTrash onClick={() => props.actionTrash()} />

            <ActionToggleNotesMode onClick={() => props.actionToggleNotesMode()} notesMode={props.notesMode} />

            {props.difficultyLevel.quickNotesAvailability
                ? <ActionQuickNotes onClick={() => props.actionQuickNotes()}/>
                : <div></div>
            }

            {props.difficultyLevel.undoAvailability
                ? <ActionUndo onClick={() => props.actionUndo()} />
                : <div></div>
            }

            <div></div>
            <div></div>
            <div></div>
            <div></div>

            <ActionRestart onClick={() => props.actionRestart()} />

        </div>
    );
}