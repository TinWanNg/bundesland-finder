/* Hooks 
track the state & fetch data when user types
*/
import React, { useState, useEffect } from 'react';

const Search = () => {
  const [query, setQuery] = useState('');  // query = user input
  const [results, setResults] = useState<any[]>([]);  // setXX are the functions setting the var

  useEffect(() => {
    if (query.length < 2) return;

    const fetchData = async () => {
      const res = await fetch('http://localhost:8000/api/graphql', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({query: `query {searchBundesland(name: "${query}") {name}}`}),
      });

      const json = await res.json();
      setResults(json.data?.searchBundesland || []);  // const results is then set, [] if fetch is empty
    };

    fetchData();
  }, [query]);  // query changes -> fetchData inside useEffect is called


  const handleCopy = (text: string) => {
    // if Clipboard API is usable
    if (navigator.clipboard && navigator.clipboard.writeText) {
      // write to clipboard directly
      navigator.clipboard.writeText(text)
        .catch((err) => {
          console.error('Clipboard write failed:', err);
          alert('Failed to copy text.');
        });
    } 
    // else for other env/ browsers
    else {
      // create an off-screen elemnt so that it's not visible
      const textarea = document.createElement('textarea');
      textarea.value = text;
      textarea.style.position = 'fixed';
      textarea.style.top = '0';
      textarea.style.left = '0';
      textarea.style.opacity = '0';
  
      // Add it to document body so that it DOM must "see" the textarea, then select its text
      document.body.appendChild(textarea);
      textarea.focus();  // like user clicking
      textarea.select();  // like user highlighting
  
      try {
        // copy using the old-school execCommand
        const successful = document.execCommand('copy');
        // alert(successful ? `Copied: ${text}` : 'Copy failed');
      } catch (err) {
        // Log and notify if that also fails
        console.error('Fallback copy failed:', err);
        alert('Copy failed');
      }
  
      // Clean up: remove the textarea from the page
      document.body.removeChild(textarea);
    }
  };
  

  return (
    <div className="p-4 max-w-xl mx-auto">
      <input
        type="text"
        placeholder="Search Bezirk or Kreis..."
        value={query}
        onChange={(e) => setQuery(e.target.value)}  // every time user types, setQuery changes value of query
        className="w-full p-2 border rounded"
      />

      <ul className="mt-4 space-y-2">
        {results.map((item, idx) => (
          <li key={idx} className="flex items-center justify-between border p-2 rounded shadow-sm">
            <p className="font-medium">{item.name}</p>
            <button
              onClick={() => handleCopy(item.name)}
              className="px-2 py-1 text-sm bg-blue-500 text-white rounded"
            >
              Copy
            </button>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Search;
