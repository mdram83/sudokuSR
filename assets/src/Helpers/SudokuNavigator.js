export class SudokuNavigator {
    static cellPrefix = 'cell-';
    static boxPrefix = 'box-';

    static generateCellId(row, column) {
        return this.cellPrefix + row + column;
    }

    static generateBoxId(row, column) {
        return this.boxPrefix + Math.floor(row / 3) + Math.floor(column / 3);
    }

    static getVisibleCellsCoordinates(row, column) {
        return [
            ...this.#getVisibleRowCells(row, column),
            ...this.#getVisibleColumnCells(row, column),
            ...this.#getVisibleBoxCells(row, column),
        ];
    }

    static #getVisibleRowCells(row, column) {
        const visibleRowCells = Array.from({length: 9}, (_, i) => [row, i]);
        visibleRowCells.splice(column, 1);
        return visibleRowCells;
    }

    static #getVisibleColumnCells(row, column) {
        const visibleColumnCells = Array.from({length: 9}, (_, i) => [i, column]);
        visibleColumnCells.splice(row, 1);
        return visibleColumnCells;
    }

    static #getVisibleBoxCells(row, column) {
        const boxStartingRow = Math.floor(row / 3) * 3;
        const boxStartingColumn = Math.floor(column / 3) * 3;

        const visibleBoxCells = Array.from({length: 9}, (_, i) => {
            return [
                boxStartingRow + Math.floor(i / 3),
                boxStartingColumn + (i % 3),
            ]
        });

        visibleBoxCells.splice(
            visibleBoxCells.findIndex((element) => element[0] === row && element[1] === column),
            1
        );

        return visibleBoxCells;
    }

    static isCellVisible(hostRow, hostColumn, row, column) {
        return (
            this.generateCellId(hostRow, hostColumn) !== this.generateCellId(row, column) &&
            (
                this.generateBoxId(hostRow, hostColumn) === this.generateBoxId(row, column)
                || hostRow === row
                || hostColumn === column
            )
        );
    }
}