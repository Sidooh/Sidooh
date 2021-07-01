const getBadge = (status) =>
    status === 'Active' ? 'success'
        : status === 'Inactive' ? 'secondary'
        : status === 'Pending' ? 'warning'
            : status === 'Banned' ? 'danger' : 'primary'


export default {
    getBadge
}
