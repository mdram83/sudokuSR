import {paths} from "../config/paths";

export class GameRepository
{
    static load(difficultyId = null, gameId = null, callback) {

        let gameSet = {
            id: null,
            initialBoard: null,
            difficulty: undefined,
        };

        const xhr = new XMLHttpRequest();

        xhr.addEventListener("readystatechange", () => {
            if (xhr.readyState === 4) {

                if (xhr.status === 200) {

                    let json = JSON.parse(xhr.responseText);

                    gameSet.id = json.id;
                    gameSet.initialBoard = json.board;
                    gameSet.difficulty = json.difficulty;

                    callback({isLoaded: true, isError: false, gameSet: gameSet});

                } else {
                    callback({isLoaded: true, isError: true});
                }
            }
        });

        xhr.open(paths.loadRandom.method, paths.loadRandom.url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
    }

    static save() {

    }
}