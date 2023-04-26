package com.daugaard47.classytoggle

import com.intellij.lang.ASTNode
import com.intellij.lang.folding.CustomFoldingBuilder
import com.intellij.lang.folding.FoldingDescriptor
import com.intellij.openapi.editor.Document
import com.intellij.openapi.util.TextRange
import com.intellij.psi.PsiElement
import com.intellij.psi.util.PsiTreeUtil
import com.intellij.psi.xml.XmlAttribute
import com.intellij.psi.xml.XmlAttributeValue
import com.intellij.psi.xml.XmlElementType

class CssClassFoldingBuilder : CustomFoldingBuilder() {
    override fun buildLanguageFoldRegions(
        descriptors: MutableList<FoldingDescriptor>,
        root: PsiElement,
        document: Document,
        quick: Boolean
    ) {
        val supportedFileExtensions = listOf("html", "js", "jsx", "ts", "tsx", "vue", "php", "blade.php")
        val currentFileExtension = root.containingFile.virtualFile.extension

        if (currentFileExtension in supportedFileExtensions) {
            val xmlAttributeValues = PsiTreeUtil.collectElementsOfType(root, XmlAttributeValue::class.java)
            for (attributeValue in xmlAttributeValues) {
                val attribute = PsiTreeUtil.getParentOfType(attributeValue, XmlAttribute::class.java)
                if (attribute?.name == "class") {
                    val valueRange = attributeValue.textRange
                    val range = TextRange(valueRange.startOffset + 1, valueRange.endOffset - 1)
                    val descriptor = FoldingDescriptor(attributeValue.node, range)
                    descriptors.add(descriptor)
                }
            }
        }
    }

    override fun getLanguagePlaceholderText(node: ASTNode, range: TextRange): String {
        return if (node.elementType === XmlElementType.XML_ATTRIBUTE_VALUE) {
            "..."
        } else ""
    }

    override fun isRegionCollapsedByDefault(node: ASTNode): Boolean {
        return false
    }
}
