var path = require('path');
var projectName = 'app',
    docRoot = path.resolve(__dirname, '..');

var Project = {
      rootFolder   :   path.resolve(__dirname, '..'),
      projectDir   :   `${docRoot}/${projectName}`,
      wpContent    :   `${docRoot}/${projectName}/wp-content`,
      themeLocation:   `${docRoot}/${projectName}/wp-content/themes/twentyseventeen`,
      urlToPreview :   'http://fictional-university.test',
}

Project.cssLocation = `${Project.themeLocation}/css`;
Project.styleModules = `${Project.cssLocation}/modules`;
Project.baseStyles = `${Project.cssLocation}/base`;
Project.scripts = `${Project.themeLocation}/js`;
Project.images = `${Project.themeLocation}/images`;
Project.icons = `${Project.images}/icons/**/*.svg`;
Project.sprites = `${Project.images}/sprites`;



module.exports = Project;

