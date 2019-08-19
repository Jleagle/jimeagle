package main

import (
	"html/template"
	"log"
	"net/http"
	"os"
	"strings"

	"github.com/go-chi/chi"
)

func main() {

	r := chi.NewRouter()
	r.Get("/", homeHandler)
	r.Get("/tools", toolsHandler)
	// r.NotFound(error404Handler)

	fileServer(r)

	err := http.ListenAndServe(":8080", r)
	if err != nil {
		log.Fatal(err)
	}
}

// func error404Handler(w http.ResponseWriter, r *http.Request) {
// }

func homeHandler(w http.ResponseWriter, r *http.Request) {

	// Load templates needed
	folder := os.Getenv("JIMEAGLE_PATH")
	if folder == "" {
		folder = "/root"
	}

	t, err := template.ParseFiles(folder + "/templates/home.html")
	if err != nil {
		panic(err)
	}

	// Write a respone
	err = t.ExecuteTemplate(w, "home", nil)
	if err != nil {
		panic(err)
	}
}

func toolsHandler(w http.ResponseWriter, r *http.Request) {

	// Load templates needed
	folder := os.Getenv("JIMEAGLE_PATH")
	if folder == "" {
		folder = "/root"
	}

	t, err := template.ParseFiles(folder + "/templates/tools.html")
	if err != nil {
		panic(err)
	}

	// Write a respone
	err = t.ExecuteTemplate(w, "tools", nil)
	if err != nil {
		panic(err)
	}
}

// FileServer conveniently sets up a http.FileServer handler to serve
// static files from a http.FileSystem.
func fileServer(r chi.Router) {

	path := "/assets"

	if strings.ContainsAny(path, "{}*") {
		panic("FileServer does not permit URL parameters.")
	}

	fs := http.StripPrefix(path, http.FileServer(http.Dir(strings.TrimLeft(path, "/"))))

	if path[len(path)-1] != '/' {
		r.Get(path, http.RedirectHandler(path+"/", 301).ServeHTTP)
		path += "/"
	}
	path += "*"

	r.Get(path, http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		fs.ServeHTTP(w, r)
	}))
}
