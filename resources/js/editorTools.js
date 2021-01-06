import Header from "@editorjs/header";
import Paragraph from "@editorjs/paragraph";
import List from "@editorjs/list";
const Quote = require('@editorjs/quote');
const LinkTool = require('@editorjs/link');
const Table = require('@editorjs/table');
const Delimiter = require('@editorjs/delimiter');
const InlineCode = require('@editorjs/inline-code');
const RawTool = require('@editorjs/raw');
const CodeTool = require('@editorjs/code');
const Marker = require('@editorjs/marker');

export default{
  header:{
    class: Header,
    shortcut: 'CMD+SHIFT+H',
  },

  paragraph: {
    class: Paragraph,
    inlineToolbar: true,
    config:{
      placeholder:"Paragraph"
    }
  },

  list: {
    class: List,
    inlineToolbar: true,
  },

  table: {
    class: Table,
    inlineToolbar: true,
    config: {
      rows: 1,
      cols: 9,
      withHeader: true,
    },
  },

  quote: Quote,

  linkTool: {
    class: LinkTool,
    config: {
      endpoint: 'http://127.0.0.1:8000/', // Your backend endpoint for url data fetching
    }
  },

  delimiter: Delimiter,

  inlineCode: {
    class: InlineCode,
    shortcut: 'CMD+SHIFT+M',
  },

  raw: RawTool,

  code: CodeTool,

  Marker: {
    class: Marker,
    shortcut: 'CMD+SHIFT+M',
  },


}