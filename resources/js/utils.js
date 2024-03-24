export function formatDate(date) {
    const year = date.getFullYear();
    let month = date.getMonth() + 1;
    month = month < 10 ? '0' + month : month; // Prefix single-digit month with '0'
    let day = date.getDate();
    day = day < 10 ? '0' + day : day; // Prefix single-digit day with '0'
    return `${year}-${month}-${day}`; // Return formatted date string (YYYY-MM-DD)
}
