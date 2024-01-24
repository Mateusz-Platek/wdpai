const usersContainer = document.querySelector('div[class="people"]');
const search = document.querySelector('input[name="search"]');

function createUser(user) {
    const template = document.querySelector(".user-template");
    const clone = template.content.cloneNode(true);
    const name = clone.querySelector('div[class="name"]');
    name.innerHTML = user.username;
    const username = clone.querySelector('input[name="username"]');
    username.setAttribute("value", user.username);
    const userID = clone.querySelector('input[name="userID"]');
    userID.setAttribute("value", user.id);
    usersContainer.appendChild(clone);
}

function loadUsers(users) {
    users.forEach(user => {
        createUser(user);
    })
}

search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};
        fetch("/searchUsers", {
            method: "POST",
            headers: {
                "Content-type": "application/json"
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (users) {
            console.log(users);
            usersContainer.innerHTML = "";
            loadUsers(users);
        });
    }
});
