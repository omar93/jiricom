/**
 * Sorts a HTML table.
 * 
 * @param {HTMLTableElement} table The table to sort
 * @param {number} column The index of the column to sort
 * @param {boolean} asc Determines if the sorting will be in ascending
 */
export function sortTableByColumn(table, column, asc = true) {
  const dirModifier = asc ? 1 : -1
  const tBody = table.tBodies[0]
  const rows = Array.from(tBody.querySelectorAll("tr"))

  // Sort each row
  const sortedRows = rows.sort((a, b) => {
    
    const aColText = a.querySelector(`td:nth-child(${column + 1})`).textContent.trim()
    const bColText = b.querySelector(`td:nth-child(${column + 1})`).textContent.trim()
    console.log(aColText)
    return aColText > bColText ? (1 * dirModifier) : (-1 * dirModifier)
  })

  // remove all TR from table so we can put it in correct order

  while(tBody.firstChild) {
    tBody.removeChild(tBody.firstChild)
  }

  // add new TR
  tBody.append(...sortedRows)

  // Remeber how the colum is currently sorted to help with the order

  table.querySelectorAll('th').forEach(th => th.classList.remove('th-sort-asc', 'th-sort-desc'))
  table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle('th-sort-asc', asc)
  table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle('th-sort-desc', !asc)
}