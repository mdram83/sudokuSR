import {paths} from "../config/paths";

export class GameRepository
{
    static load(difficultyId = null, resumeGame = false, callback) {

        const url = resumeGame === true ? paths.resumeGame.url : paths.loadRandom.url;
        const xhr = new XMLHttpRequest();

        xhr.addEventListener("readystatechange", () => {
            if (xhr.readyState === 4) {

                if (xhr.status === 200) {

                    let json = JSON.parse(xhr.responseText);
                    let gameSet;

                    if (json !== null) {
                        gameSet = {
                            resumed: !!json.sudoku,
                            sudoku: json.sudoku ?? json,
                            initialBoard: json.initialBoard,
                            board: json.board ?? null,
                            boardErrors: json.boardErrors ?? null,
                            notes: json.notes ?? null,
                            notesErrors: json.notesErrors ?? null,
                            emptyCellsCount: json.emptyCellsCount ?? null,
                            difficultyLevel: json.difficultyLevel ?? null,
                            timer: json.timer ?? null,
                        }
                    } else {
                        gameSet = null;
                    }

                    callback({isLoaded: true, isError: false, gameSet: gameSet});

                } else {
                    callback({isLoaded: true, isError: true});
                }
            }
        });

        xhr.open('GET', url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
    }

    static save() {

    }
}