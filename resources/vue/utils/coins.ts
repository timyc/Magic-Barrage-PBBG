export default function coins(amount: number): string {
    let total = '';
    let platinum = Math.floor(amount / 1000000);
    let gold = Math.floor((amount - (platinum * 1000000)) / 10000);
    let silver = Math.floor((amount - (platinum * 1000000) - (gold * 10000)) / 100);
    let copper = amount - (platinum * 1000000) - (gold * 10000) - (silver * 100);

    if (platinum > 0) {
        total = '<span title="platinum" style="color:#e5e4e2">' + platinum + 'p</span> <span title="gold" style="color:#FFD700">' + gold + 'g</span> <span title="silver" style="color:#C0C0C0">' + silver + 's</span> <span title="copper" style="color:#b87333">' + copper + 'c</span>';
    }
    if (platinum == 0 && gold > 0) {
        total = '<span title="gold" style="color:#FFD700">' + gold + 'g</span> <span title="silver" style="color:#C0C0C0">' + silver + 's</span> <span title="copper" style="color:#b87333">' + copper + 'c</span>';
    }
    if (platinum == 0 && gold == 0 && silver > 0) {
        total = '<span title="silver" style="color:#C0C0C0">' + silver + 's</span> <span title="copper" style="color:#b87333">' + copper + 'c</span>';
    }
    if (platinum == 0 && gold == 0 && silver == 0) {
        total = '<span title="copper" style="color:#b87333">' + copper + 'c</span>';
    }
    return total;
}