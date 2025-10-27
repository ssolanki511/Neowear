// vite.config.js
import { defineConfig } from "file:///D:/laragon/www/NeoWear/node_modules/vite/dist/node/index.js";
import laravel from "file:///D:/laragon/www/NeoWear/node_modules/laravel-vite-plugin/dist/index.js";
import tailwindcss from "file:///D:/laragon/www/NeoWear/node_modules/@tailwindcss/vite/dist/index.mjs";
import { viteStaticCopy } from "file:///D:/laragon/www/NeoWear/node_modules/vite-plugin-static-copy/dist/index.js";
var vite_config_default = defineConfig({
  plugins: [
    tailwindcss(),
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true
    }),
    viteStaticCopy({
      targets: [
        {
          src: "node_modules/remixicon/fonts/*",
          dest: "fonts"
        }
      ]
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFxOZW9XZWFyXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJEOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFxOZW9XZWFyXFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9EOi9sYXJhZ29uL3d3dy9OZW9XZWFyL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB0YWlsd2luZGNzcyBmcm9tIFwiQHRhaWx3aW5kY3NzL3ZpdGVcIjtcbmltcG9ydCB7IHZpdGVTdGF0aWNDb3B5IH0gZnJvbSAndml0ZS1wbHVnaW4tc3RhdGljLWNvcHknO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgdGFpbHdpbmRjc3MoKSxcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogWydyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLCAncmVzb3VyY2VzL2pzL2FwcC5qcyddLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG4gICAgICAgIHZpdGVTdGF0aWNDb3B5KHtcbiAgICAgICAgICAgIHRhcmdldHM6IFtcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHNyYzogJ25vZGVfbW9kdWxlcy9yZW1peGljb24vZm9udHMvKicsXG4gICAgICAgICAgICAgICAgICAgIGRlc3Q6ICdmb250cydcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICBdXG4gICAgICAgIH0pXG4gICAgXSxcbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUE0UCxTQUFTLG9CQUFvQjtBQUN6UixPQUFPLGFBQWE7QUFDcEIsT0FBTyxpQkFBaUI7QUFDeEIsU0FBUyxzQkFBc0I7QUFFL0IsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsU0FBUztBQUFBLElBQ0wsWUFBWTtBQUFBLElBQ1osUUFBUTtBQUFBLE1BQ0osT0FBTyxDQUFDLHlCQUF5QixxQkFBcUI7QUFBQSxNQUN0RCxTQUFTO0FBQUEsSUFDYixDQUFDO0FBQUEsSUFDRCxlQUFlO0FBQUEsTUFDWCxTQUFTO0FBQUEsUUFDTDtBQUFBLFVBQ0ksS0FBSztBQUFBLFVBQ0wsTUFBTTtBQUFBLFFBQ1Y7QUFBQSxNQUNKO0FBQUEsSUFDSixDQUFDO0FBQUEsRUFDTDtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
