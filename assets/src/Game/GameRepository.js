import {paths} from "../config/paths";

export class GameRepository
{
    load(difficultyId = null, gameId = null, callback) {

        let gameSet = {
            initialBoard: null,
        };

        const xhr = new XMLHttpRequest();

        xhr.addEventListener("readystatechange", () => {
            if (xhr.readyState === 4) {

                if (xhr.status === 200) {

                    let json = JSON.parse(xhr.responseText);
                    gameSet.initialBoard = json.board;

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

    save() {

    }
}