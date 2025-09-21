class GraphJSApi {
    static baseUrl = window.location.protocol + window.location.host + '/api/graphjs/';
    
    static async get(endpoint, params = {}) {
        const url = new URL(this.baseUrl + endpoint);
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        return response.json();
    }

    static async post(endpoint, data = {}) {
        const response = await fetch(this.baseUrl + endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        });
        return response.json();
    }
}
