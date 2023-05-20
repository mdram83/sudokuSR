import React from "react";
import {DifficultyLevelHighlightValue} from "./DifficultyLevelHighlightValue";
import {DifficultyLevelHighlightNotes} from "./DifficultyLevelHighlightNotes";
import {DifficultyLevelHighlightGrid} from "./DifficultyLevelHighlightGrid";
import {DifficultyLevelQuickNotesRemoval} from "./DifficultyLevelQuickNotesRemoval";
import {DifficultyLevelUndoAvailability} from "./DifficultyLevelUndoAvailability";
import {DifficultyLevelHighlightRemaining} from "./DifficultyLevelHighlightRemaining";
import {DifficultyLevelHighlightErrors} from "./DifficultyLevelHighlightErrors";
import {DifficultyLevelQuickNotesAvailability} from "./DifficultyLevelQuickNotesAvailability";
import {DifficultyLevelToggleAll} from "./DifficultyLevelToggleAll";

export const DifficultyBoard = (props) => {
    return (
        <div className="grid grid-cols-9 gap-1 w-72 h-8 mt-8">

            <DifficultyLevelHighlightValue
                active={props.difficultyLevel.highlightValue}
                onClick={() => props.toggleDifficultyLevel(
                    'highlightValue', !props.difficultyLevel.highlightValue
                )}
            />

            <DifficultyLevelHighlightNotes
                active={props.difficultyLevel.highlightNotes}
                onClick={() => props.toggleDifficultyLevel(
                    'highlightNotes', !props.difficultyLevel.highlightNotes
                )}
            />

            <DifficultyLevelHighlightGrid
                active={props.difficultyLevel.highlightGrid}
                onClick={() => props.toggleDifficultyLevel(
                    'highlightGrid', !props.difficultyLevel.highlightGrid
                )}
            />

            <DifficultyLevelQuickNotesRemoval
                active={props.difficultyLevel.quickNotesRemoval}
                onClick={() => props.toggleDifficultyLevel(
                    'quickNotesRemoval', !props.difficultyLevel.quickNotesRemoval
                )}
            />

            <DifficultyLevelUndoAvailability
                active={props.difficultyLevel.undoAvailability}
                onClick={() => props.toggleDifficultyLevel(
                    'undoAvailability', !props.difficultyLevel.undoAvailability
                )}
            />

            <DifficultyLevelHighlightRemaining
                active={props.difficultyLevel.highlightRemaining}
                onClick={() => props.toggleDifficultyLevel(
                    'highlightRemaining', !props.difficultyLevel.highlightRemaining
                )}
            />

            <DifficultyLevelHighlightErrors
                active={props.difficultyLevel.highlightErrors}
                onClick={() => props.toggleDifficultyLevel(
                    'highlightErrors', !props.difficultyLevel.highlightErrors
                )}
            />

            <DifficultyLevelQuickNotesAvailability
                active={props.difficultyLevel.quickNotesAvailability}
                onClick={() => props.toggleDifficultyLevel(
                    'quickNotesAvailability', !props.difficultyLevel.quickNotesAvailability
                )}
            />

            <DifficultyLevelToggleAll
                difficultyLevel={props.difficultyLevel}
                toggleAll={() => props.toggleAllDifficultyLevels()}
            />

        </div>
    );
}