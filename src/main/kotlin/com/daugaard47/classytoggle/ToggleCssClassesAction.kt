package com.daugaard47.classytoggle

import com.intellij.codeInsight.folding.CodeFoldingManager
import com.intellij.openapi.actionSystem.AnAction
import com.intellij.openapi.actionSystem.AnActionEvent
import com.intellij.openapi.editor.Document
import com.intellij.openapi.editor.Editor
import com.intellij.openapi.editor.FoldRegion
import com.intellij.openapi.project.Project

class ToggleCssClassesAction : AnAction() {
    override fun actionPerformed(e: AnActionEvent) {
        val project: Project = e.project ?: return
        val editor = e.getData(com.intellij.openapi.actionSystem.PlatformDataKeys.EDITOR) ?: return
        val document: Document = editor.document

        toggleClasses(editor, document, project)
    }

    private fun toggleClasses(editor: Editor, document: Document, project: Project) {
        val foldingManager = CodeFoldingManager.getInstance(project)
        foldingManager.updateFoldRegions(editor)

        val foldingModel = editor.foldingModel

        foldingModel.runBatchFoldingOperation {
            val text = document.text
            val regex = Regex("""class="([^"]+)"|class='([^']+)'""")
            val foldRegions = mutableListOf<FoldRegion>()

            regex.findAll(text).forEach { result ->
                val range = result.range
                val start = range.first
                val end = range.last
                val foldRegion: FoldRegion? = foldingModel.getFoldRegion(start, end + 1)
                if (foldRegion != null) {
                    foldRegions.add(foldRegion)
                } else {
                    foldingModel.addFoldRegion(start, end + 1, "...")
                }
            }

            val anyCollapsed = foldRegions.any { !it.isExpanded }

            foldRegions.forEach { foldRegion ->
                foldRegion.isExpanded = if (!anyCollapsed) {
                    false
                } else {
                    !foldRegion.isExpanded
                }
            }
        }
    }
}
